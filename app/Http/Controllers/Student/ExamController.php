<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\UserExamAttempt;
use App\Models\UserExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ExamController extends Controller
{
    /**
     * List available exams for the logged-in student.
     */
    public function index()
    {
        $user = Auth::user();

        $exams = Exam::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        $attemptsByExam = $user->examAttempts()
            ->selectRaw('exam_id, COUNT(*) as count')
            ->groupBy('exam_id')
            ->pluck('count', 'exam_id');

        return view('student.exams.index', compact('exams', 'attemptsByExam'));
    }

    /**
     * Show exam instructions/details.
     */
    public function show(Exam $exam)
    {
        $user = Auth::user();

        if (! $exam->is_active) {
            abort(404);
        }

        $attemptCount = $user->examAttempts()
            ->where('exam_id', $exam->id)
            ->count();

        return view('student.exams.show', compact('exam', 'attemptCount'));
    }

    /**
     * Start a new attempt (if attempt limit not exceeded).
     */
    public function start(Exam $exam)
    {
        $user = Auth::user();

        if (! $exam->is_active) {
            abort(404);
        }

        $existingAttempts = $user->examAttempts()
            ->where('exam_id', $exam->id);

        $attemptCount = $existingAttempts->count();

        if (! is_null($exam->attempt_limit) && $attemptCount >= $exam->attempt_limit) {
            return redirect()
                ->route('student.exams.show', $exam)
                ->with('status', 'You have reached the maximum number of attempts for this exam.');
        }

        $attemptNumber = $attemptCount + 1;

        $attempt = UserExamAttempt::create([
            'user_id'         => $user->id,
            'exam_id'         => $exam->id,
            'attempt_number'  => $attemptNumber,
            'started_at'      => Carbon::now(),
            'status'          => 'in_progress',
            'total_questions' => $exam->questions()->count(),
        ]);

        foreach ($exam->questions as $question) {
            UserExamAnswer::create([
                'user_exam_attempt_id' => $attempt->id,
                'question_id'          => $question->id,
                'selected_option'      => null,
                'is_correct'           => false,
                'time_spent_seconds'   => null,
            ]);
        }

        return redirect()->route('student.exams.take', [$exam, $attempt]);
    }

    /**
     * Show the exam page (simple one-page version).
     */
    public function take(Exam $exam, UserExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->exam_id !== $exam->id) {
            abort(403);
        }

        if ($attempt->status === 'completed') {
            return redirect()->route('student.exams.result', [$exam, $attempt]);
        }

        $attempt->load(['answers.question']);

        $answers = $attempt->answers->sortBy(function ($answer) use ($exam) {
            $pivot = $exam->questions()
                ->where('questions.id', $answer->question_id)
                ->first()?->pivot;

            return $pivot?->question_order ?? $answer->id;
        });

        return view('student.exams.take', [
            'exam'    => $exam,
            'attempt' => $attempt,
            'answers' => $answers,
        ]);
    }

    /**
     * Handle submission of the exam.
     */
    public function submit(Request $request, Exam $exam, UserExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->exam_id !== $exam->id) {
            abort(403);
        }

        if ($attempt->status === 'completed') {
            return redirect()->route('student.exams.result', [$exam, $attempt]);
        }

        $data = $request->input('answers', []); // answers[question_id] = selected_option

        $correctCount = 0;
        $incorrectCount = 0;
        $skippedCount = 0;

        $answers = $attempt->answers()->with('question')->get();

        foreach ($answers as $answer) {
            $questionId = $answer->question_id;
            $selected = $data[$questionId] ?? null;

            $answer->selected_option = $selected;

            if ($selected === null || $selected === '') {
                $answer->is_correct = false;
                $skippedCount++;
            } else {
                if ($selected === $answer->question->correct_option) {
                    $answer->is_correct = true;
                    $correctCount++;
                } else {
                    $answer->is_correct = false;
                    $incorrectCount++;
                }
            }

            $answer->save();
        }

        $totalQuestions = $answers->count();
        $score = $correctCount;
        $percentage = $totalQuestions > 0
            ? round(($correctCount / $totalQuestions) * 100, 2)
            : 0;

        $attempt->update([
            'completed_at'    => Carbon::now(),
            'status'          => 'completed',
            'total_questions' => $totalQuestions,
            'correct_count'   => $correctCount,
            'incorrect_count' => $incorrectCount,
            'skipped_count'   => $skippedCount,
            'score'           => $score,
            'percentage'      => $percentage,
        ]);

        return redirect()->route('student.exams.result', [$exam, $attempt]);
    }

    /**
     * Show result summary for a completed attempt.
     */
    public function result(Exam $exam, UserExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->exam_id !== $exam->id) {
            abort(403);
        }

        if ($attempt->status !== 'completed') {
            return redirect()->route('student.exams.take', [$exam, $attempt]);
        }

        $attempt->load(['answers.question']);

        return view('student.exams.result', [
            'exam'    => $exam,
            'attempt' => $attempt,
        ]);
    }
}
