<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exam – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-4">Edit Exam #{{ $exam->id }}</h1>

        <a href="{{ route('admin.exams.index') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
            ← Back to exams
        </a>

        @if ($errors->any())
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.exams.update', $exam) }}" method="POST"
              class="bg-white shadow rounded px-4 py-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('title', $exam->title) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description (optional)</label>
                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $exam->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium mb-1">Timing</label>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_timed" value="1"
                               @checked(old('is_timed', $exam->is_timed))>
                        <span class="text-sm">Timed exam</span>
                    </div>
                    <input type="number" name="duration_minutes" min="1"
                           class="w-full border rounded px-3 py-2 text-sm"
                           placeholder="Duration in minutes"
                           value="{{ old('duration_minutes', $exam->duration_minutes) }}">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium mb-1">Attempt limit</label>
                    <input type="number" name="attempt_limit" min="1"
                           class="w-full border rounded px-3 py-2 text-sm"
                           placeholder="Leave empty for unlimited"
                           value="{{ old('attempt_limit', $exam->attempt_limit) }}">
                    <label class="flex items-center space-x-2 mt-2">
                        <input type="checkbox" name="is_active" value="1"
                               @checked(old('is_active', $exam->is_active))>
                        <span class="text-sm">Exam is active</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="shuffle_questions" value="1"
                               @checked(old('shuffle_questions', $exam->shuffle_questions))>
                        <span class="text-sm">Shuffle questions</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="shuffle_options" value="1"
                               @checked(old('shuffle_options', $exam->shuffle_options))>
                        <span class="text-sm">Shuffle answer options</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Questions</label>
                <p class="text-xs text-gray-500 mb-1">
                    Hold Ctrl (Cmd on Mac) to select multiple questions.
                </p>
                <select name="question_ids[]" multiple size="10"
                        class="w-full border rounded px-3 py-2 text-sm" required>
                    @foreach($questions as $question)
                        <option value="{{ $question->id }}"
                            @if(collect(old('question_ids', $selectedQuestionIds))->contains($question->id)) selected @endif>
                            #{{ $question->id }} — {{ Str::limit($question->question_text, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
