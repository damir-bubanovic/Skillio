<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Edit Exam — {{ $exam->title }}
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

            <form action="{{ route('admin.exams.update', $exam) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Exam Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $exam->title) }}"
                        required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                    >
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Description (optional)
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                    >{{ old('description', $exam->description) }}</textarea>
                </div>

                <!-- Timed Exam -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Timed Exam?
                        </label>
                        @php
                            $timedValue = old('is_timed', $exam->is_timed);
                        @endphp
                        <select
                            name="is_timed"
                            id="is_timed"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                        >
                            <option value="0" @selected($timedValue == 0)>No</option>
                            <option value="1" @selected($timedValue == 1)>Yes</option>
                        </select>
                    </div>

                    <!-- Duration -->
                    <div id="duration_field" class="{{ old('is_timed', $exam->is_timed) == 1 ? '' : 'hidden' }}">
                        <label class="block text-sm font-semibold text-slate-200 mb-1">
                            Duration (minutes)
                        </label>
                        <input
                            type="number"
                            name="duration_minutes"
                            value="{{ old('duration_minutes', $exam->duration_minutes) }}"
                            min="1"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                        >
                    </div>
                </div>

                <!-- Attempt Limit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Attempt Limit (leave empty for unlimited)
                    </label>
                    <input
                        type="number"
                        name="attempt_limit"
                        value="{{ old('attempt_limit', $exam->attempt_limit) }}"
                        min="1"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 focus:border-red-500 focus:ring-red-500"
                    >
                </div>

                <!-- Shuffle / Active flags -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-200">
                        <input
                            type="checkbox"
                            name="shuffle_questions"
                            value="1"
                            class="rounded bg-slate-800 border-slate-600 text-red-600"
                            @checked(old('shuffle_questions', $exam->shuffle_questions))
                        >
                        Shuffle questions
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm text-slate-200">
                        <input
                            type="checkbox"
                            name="shuffle_options"
                            value="1"
                            class="rounded bg-slate-800 border-slate-600 text-red-600"
                            @checked(old('shuffle_options', $exam->shuffle_options))
                        >
                        Shuffle options
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm text-slate-200">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="rounded bg-slate-800 border-slate-600 text-red-600"
                            @checked(old('is_active', $exam->is_active))
                        >
                        Active exam
                    </label>
                </div>

                <!-- Questions multi-select -->
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-1">
                        Questions
                    </label>
                    <p class="text-xs text-slate-400 mb-2">
                        Hold Ctrl (Cmd on Mac) to select multiple questions. At least one question is required.
                    </p>

                    @php
                        $oldSelected = collect(old('question_ids', $selectedQuestionIds ?? []));
                    @endphp

                    @if($questions->isEmpty())
                        <p class="text-sm text-red-300">
                            There are no questions yet. Create questions first, then edit the exam to assign them.
                        </p>
                    @else
                        <select
                            name="question_ids[]"
                            multiple
                            size="10"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 text-slate-200 px-3 py-2 text-sm focus:border-red-500 focus:ring-red-500"
                            required
                        >
                            @foreach($questions as $question)
                                <option value="{{ $question->id }}"
                                    @if($oldSelected->contains($question->id)) selected @endif>
                                    #{{ $question->id }} —
                                    {{ \Illuminate\Support\Str::limit($question->question_text, 80) }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <a
                        href="{{ route('admin.exams.index') }}"
                        class="text-red-300 hover:text-red-200 underline text-sm"
                    >
                        ← Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg shadow transition"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        const timedSelect = document.getElementById('is_timed');
        const durationField = document.getElementById('duration_field');

        timedSelect.addEventListener('change', function () {
            if (this.value === '1') {
                durationField.classList.remove('hidden');
            } else {
                durationField.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
