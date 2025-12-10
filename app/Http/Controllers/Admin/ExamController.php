<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the exams.
     */
    public function index()
    {
        $exams = Exam::orderByDesc('created_at')->paginate(15);

        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new exam.
     */
    public function create()
    {
        $questions = Question::orderBy('id', 'desc')->get();

        return view('admin.exams.create', compact('questions'));
    }

    /**
     * Store a newly created exam in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'is_timed'         => ['nullable', 'boolean'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'attempt_limit'    => ['nullable', 'integer', 'min:1'],
            'shuffle_questions'=> ['nullable', 'boolean'],
            'shuffle_options'  => ['nullable', 'boolean'],
            'is_active'        => ['nullable', 'boolean'],
            'question_ids'     => ['required', 'array', 'min:1'],
            'question_ids.*'   => ['integer', 'exists:questions,id'],
        ]);

        $isTimed = $request->boolean('is_timed');
        $shuffleQuestions = $request->boolean('shuffle_questions');
        $shuffleOptions = $request->boolean('shuffle_options');
        $isActive = $request->boolean('is_active');

        if (! $isTimed) {
            $validated['duration_minutes'] = null;
        }

        $exam = Exam::create([
            'title'            => $validated['title'],
            'description'      => $validated['description'] ?? null,
            'is_timed'         => $isTimed,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'attempt_limit'    => $validated['attempt_limit'] ?? null,
            'shuffle_questions'=> $shuffleQuestions,
            'shuffle_options'  => $shuffleOptions,
            'is_active'        => $isActive,
            'created_by'       => Auth::id(),
        ]);

        $questionIds = $validated['question_ids'];

        $exam->questions()->sync(
            collect($questionIds)->mapWithKeys(function ($id, $index) {
                return [$id => ['question_order' => $index + 1]];
            })->toArray()
        );

        return redirect()
            ->route('admin.exams.index')
            ->with('status', 'Exam created successfully.');
    }

    /**
     * Show the form for editing the specified exam.
     */
    public function edit(Exam $exam)
    {
        $questions = Question::orderBy('id', 'desc')->get();
        $selectedQuestionIds = $exam->questions()->pluck('questions.id')->toArray();

        return view('admin.exams.edit', compact('exam', 'questions', 'selectedQuestionIds'));
    }

    /**
     * Update the specified exam in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'is_timed'         => ['nullable', 'boolean'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'attempt_limit'    => ['nullable', 'integer', 'min:1'],
            'shuffle_questions'=> ['nullable', 'boolean'],
            'shuffle_options'  => ['nullable', 'boolean'],
            'is_active'        => ['nullable', 'boolean'],
            'question_ids'     => ['required', 'array', 'min:1'],
            'question_ids.*'   => ['integer', 'exists:questions,id'],
        ]);

        $isTimed = $request->boolean('is_timed');
        $shuffleQuestions = $request->boolean('shuffle_questions');
        $shuffleOptions = $request->boolean('shuffle_options');
        $isActive = $request->boolean('is_active');

        if (! $isTimed) {
            $validated['duration_minutes'] = null;
        }

        $exam->update([
            'title'            => $validated['title'],
            'description'      => $validated['description'] ?? null,
            'is_timed'         => $isTimed,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'attempt_limit'    => $validated['attempt_limit'] ?? null,
            'shuffle_questions'=> $shuffleQuestions,
            'shuffle_options'  => $shuffleOptions,
            'is_active'        => $isActive,
        ]);

        $questionIds = $validated['question_ids'];

        $exam->questions()->sync(
            collect($questionIds)->mapWithKeys(function ($id, $index) {
                return [$id => ['question_order' => $index + 1]];
            })->toArray()
        );

        return redirect()
            ->route('admin.exams.index')
            ->with('status', 'Exam updated successfully.');
    }

    /**
     * Remove the specified exam from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('admin.exams.index')
            ->with('status', 'Exam deleted successfully.');
    }
}
