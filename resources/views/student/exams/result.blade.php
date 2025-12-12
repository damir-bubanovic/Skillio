<x-app-layout>
    @php
        // We rely on $attempt->load(['answers.question']) in the controller
        $answers = $attempt->answers;
        $totalQuestions = $answers->count();
        $correctCount = $answers->where('is_correct', true)->count();
        $percentage = $totalQuestions > 0
            ? round(($correctCount / $totalQuestions) * 100, 2)
            : 0;
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Exam Result — {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Summary card -->
        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md mb-8">
            <h3 class="text-lg font-semibold text-red-300 mb-3">Summary</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <p class="text-slate-300">
                    <span class="font-semibold text-slate-200">Attempt:</span>
                    #{{ $attempt->attempt_number }}
                </p>

                <p class="text-slate-300">
                    <span class="font-semibold text-slate-200">Score:</span>
                    {{ $correctCount }} / {{ $totalQuestions }}
                </p>

                <p class="text-slate-300">
                    <span class="font-semibold text-slate-200">Percentage:</span>
                    {{ $percentage }}%
                </p>

                <p class="text-slate-300">
                    <span class="font-semibold text-slate-200">Status:</span>
                    @if($attempt->status === 'completed')
                        <span class="text-green-300">Completed</span>
                    @else
                        <span class="text-yellow-300">In progress</span>
                    @endif
                </p>

                <p class="text-slate-300">
                    <span class="font-semibold text-slate-200">Completed at:</span>
                    {{ $attempt->completed_at ?? $attempt->created_at }}
                </p>
            </div>
        </div>

        <!-- Answers list -->
        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold text-red-300 mb-4">Your Answers</h3>

            <div class="space-y-6">
                @foreach ($answers as $index => $answer)
                    @php
                        $question = $answer->question;
                        $correct = $answer->is_correct;
                        $selectedOption = $answer->selected_option;
                        $correctOption = $question->correct_option;

                        $selectedText = $selectedOption
                            ? $question->{'option_' . $selectedOption}
                            : null;

                        $correctText = $correctOption
                            ? $question->{'option_' . $correctOption}
                            : null;
                    @endphp

                    <div class="border-b border-slate-800 pb-4 last:border-b-0 last:pb-0">
                        <p class="font-semibold mb-2 text-slate-100">
                            Q{{ $index + 1 }}. {{ $question->question_text }}
                        </p>

                        <p class="text-sm mb-1">
                            <span class="font-semibold text-slate-200">Your answer:</span>
                            @if($selectedOption)
                                <span class="{{ $correct ? 'text-green-300' : 'text-red-300' }}">
                                    {{ strtoupper($selectedOption) }}
                                    @if($selectedText)
                                        — {{ $selectedText }}
                                    @endif
                                </span>
                            @else
                                <span class="text-slate-400">No answer given</span>
                            @endif
                        </p>

                        <p class="text-sm">
                            <span class="font-semibold text-slate-200">Correct answer:</span>
                            <span class="text-green-300">
                                {{ strtoupper($correctOption) }}
                                @if($correctText)
                                    — {{ $correctText }}
                                @endif
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a
                href="{{ route('student.results.index') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                ← Back to results
            </a>

            <a
                href="{{ route('student.exams.index') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                Try another exam →
            </a>
        </div>
    </div>
</x-app-layout>
