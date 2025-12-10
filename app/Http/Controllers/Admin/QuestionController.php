<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index()
    {
        $questions = Question::orderByDesc('created_at')->paginate(15);

        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text'   => ['required', 'string'],
            'option_a'        => ['required', 'string', 'max:255'],
            'option_b'        => ['required', 'string', 'max:255'],
            'option_c'        => ['required', 'string', 'max:255'],
            'option_d'        => ['required', 'string', 'max:255'],
            'option_e'        => ['nullable', 'string', 'max:255'],
            'correct_option'  => ['required', 'in:a,b,c,d,e'],
            'explanation'     => ['nullable', 'string'],
            'category'        => ['nullable', 'string', 'max:255'],
            'difficulty'      => ['required', 'in:easy,medium,hard'],
            'image'           => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        Question::create([
            'question_text'  => $validated['question_text'],
            'option_a'       => $validated['option_a'],
            'option_b'       => $validated['option_b'],
            'option_c'       => $validated['option_c'],
            'option_d'       => $validated['option_d'],
            'option_e'       => $validated['option_e'] ?? null,
            'correct_option' => $validated['correct_option'],
            'explanation'    => $validated['explanation'] ?? null,
            'category'       => $validated['category'] ?? null,
            'difficulty'     => $validated['difficulty'],
            'image_path'     => $imagePath,
            'created_by'     => Auth::id(),
        ]);

        return redirect()
            ->route('admin.questions.index')
            ->with('status', 'Question created successfully.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text'   => ['required', 'string'],
            'option_a'        => ['required', 'string', 'max:255'],
            'option_b'        => ['required', 'string', 'max:255'],
            'option_c'        => ['required', 'string', 'max:255'],
            'option_d'        => ['required', 'string', 'max:255'],
            'option_e'        => ['nullable', 'string', 'max:255'],
            'correct_option'  => ['required', 'in:a,b,c,d,e'],
            'explanation'     => ['nullable', 'string'],
            'category'        => ['nullable', 'string', 'max:255'],
            'difficulty'      => ['required', 'in:easy,medium,hard'],
            'image'           => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $question->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question->update([
            'question_text'  => $validated['question_text'],
            'option_a'       => $validated['option_a'],
            'option_b'       => $validated['option_b'],
            'option_c'       => $validated['option_c'],
            'option_d'       => $validated['option_d'],
            'option_e'       => $validated['option_e'] ?? null,
            'correct_option' => $validated['correct_option'],
            'explanation'    => $validated['explanation'] ?? null,
            'category'       => $validated['category'] ?? null,
            'difficulty'     => $validated['difficulty'],
            'image_path'     => $imagePath,
        ]);

        return redirect()
            ->route('admin.questions.index')
            ->with('status', 'Question updated successfully.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Question $question)
    {
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('status', 'Question deleted successfully.');
    }
}
