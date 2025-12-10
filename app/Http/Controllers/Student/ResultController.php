<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\UserExamAttempt;
use App\Models\UserExamAnswer;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $attempts = UserExamAttempt::with('exam')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderByDesc('created_at')
            ->get();

        return view('student.results.index', compact('attempts'));
    }

    public function topics()
    {
        $user = Auth::user();

        $rows = UserExamAnswer::with('question')
            ->whereHas('attempt', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('status', 'completed');
            })
            ->get();

        $summary = [];

        foreach ($rows as $row) {
            $category = $row->question->category ?? 'Uncategorized';

            if (! isset($summary[$category])) {
                $summary[$category] = [
                    'total'    => 0,
                    'correct'  => 0,
                ];
            }

            $summary[$category]['total']++;

            if ($row->is_correct) {
                $summary[$category]['correct']++;
            }
        }

        foreach ($summary as $category => $data) {
            $summary[$category]['percentage'] = $data['total'] > 0
                ? round(($data['correct'] / $data['total']) * 100, 2)
                : 0;
        }

        return view('student.results.topics', compact('summary'));
    }
}
