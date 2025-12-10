<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function questions()
    {
        $stats = DB::table('user_exam_answers')
            ->select(
                'question_id',
                DB::raw('COUNT(*) as attempts'),
                DB::raw('SUM(is_correct) as correct'),
                DB::raw('ROUND((SUM(is_correct) / COUNT(*)) * 100, 2) as difficulty')
            )
            ->groupBy('question_id')
            ->get();

        $questions = Question::whereIn('id', $stats->pluck('question_id'))
            ->get()
            ->keyBy('id');

        return view('admin.stats.questions', compact('stats', 'questions'));
    }
}
