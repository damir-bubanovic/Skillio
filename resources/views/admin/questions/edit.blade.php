<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Edit Question #{{ $question->id }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-700 bg-red-900/40 px-4 py-3 text-sm text-red-200">
                    <p class="font-semibold mb-1">There were some problems with your input:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Category (string) + Difficulty -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Category (optional)
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $question->category) }}"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Difficulty
                        </label>
                        <select
                            name="difficulty"
                            required
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                        >
                            <option value="easy" @selected(old('difficulty', $question->difficulty) === 'easy')>Easy</option>
                            <option value="medium" @selected(old('difficulty', $question->difficulty) === 'medium')>Medium</option>
                            <option value="hard" @selected(old('difficulty', $question->difficulty) === 'hard')>Hard</option>
                        </select>
                    </div>
                </div>

                <!-- Question text -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Question
                    </label>
                    <textarea
                        name="question_text"
                        rows="3"
                        required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                    >{{ old('question_text', $question->question_text) }}</textarea>
                </div>

                <!-- Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">Option A</label>
                        <input type="text" name="option_a" value="{{ old('option_a', $question->option_a) }}" required
                               class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">Option B</label>
                        <input type="text" name="option_b" value="{{ old('option_b', $question->option_b) }}" required
                               class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">Option C</label>
                        <input type="text" name="option_c" value="{{ old('option_c', $question->option_c) }}" required
                               class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">Option D</label>
                        <input type="text" name="option_d" value="{{ old('option_d', $question->option_d) }}" required
                               class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-200 mb-1">Option E (optional)</label>
                        <input type="text" name="option_e" value="{{ old('option_e', $question->option_e) }}"
                               class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500">
                    </div>
                </div>

                <!-- Correct option -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Correct Option
                    </label>
                    <select
                        name="correct_option"
                        required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                    >
                        @foreach(['a','b','c','d','e'] as $opt)
                            <option value="{{ $opt }}" @selected(old('correct_option', $question->correct_option) === $opt)>
                                {{ strtoupper($opt) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Explanation + Image -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Explanation (optional)
                        </label>
                        <textarea
                            name="explanation"
                            rows="4"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                        >{{ old('explanation', $question->explanation) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Replace Image (optional)
                        </label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="block w-full text-sm text-slate-200
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-red-600 file:text-white
                                   hover:file:bg-red-500"
                        >

                        @if($question->image_path)
                            <p class="text-xs text-slate-400 mt-2">
                                Current: <span class="text-slate-300">{{ $question->image_path }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('admin.questions.index') }}" class="text-red-300 hover:text-red-200 underline text-sm">
                        ← Cancel
                    </a>

                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg shadow transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
