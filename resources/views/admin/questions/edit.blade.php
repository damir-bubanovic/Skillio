<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-4">Edit Question #{{ $question->id }}</h1>

        <a href="{{ route('admin.questions.index') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
            ← Back to list
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

        <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data"
              class="bg-white shadow rounded px-4 py-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Question text</label>
                <textarea name="question_text" rows="4" class="w-full border rounded px-3 py-2 text-sm"
                          required>{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Option A</label>
                <input type="text" name="option_a" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('option_a', $question->option_a) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Option B</label>
                <input type="text" name="option_b" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('option_b', $question->option_b) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Option C</label>
                <input type="text" name="option_c" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('option_c', $question->option_c) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Option D</label>
                <input type="text" name="option_d" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('option_d', $question->option_d) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Option E (optional)</label>
                <input type="text" name="option_e" class="w-full border rounded px-3 py-2 text-sm"
                       value="{{ old('option_e', $question->option_e) }}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Correct option</label>
                <select name="correct_option" class="w-full border rounded px-3 py-2 text-sm" required>
                    @foreach(['a','b','c','d','e'] as $opt)
                        <option value="{{ $opt }}"
                            @selected(old('correct_option', $question->correct_option) === $opt)>
                            {{ strtoupper($opt) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Explanation (optional)</label>
                <textarea name="explanation" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('explanation', $question->explanation) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Category (optional)</label>
                    <input type="text" name="category" class="w-full border rounded px-3 py-2 text-sm"
                           value="{{ old('category', $question->category) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Difficulty</label>
                    <select name="difficulty" class="w-full border rounded px-3 py-2 text-sm" required>
                        @foreach(['easy','medium','hard'] as $diff)
                            <option value="{{ $diff }}"
                                @selected(old('difficulty', $question->difficulty) === $diff)>
                                {{ ucfirst($diff) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Image (optional)</label>
                @if($question->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$question->image_path) }}"
                             alt="Question image" class="max-h-40">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="text-sm">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    Update Question
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
