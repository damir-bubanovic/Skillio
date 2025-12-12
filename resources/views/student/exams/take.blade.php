<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $exam->title }}
            </h2>
            <div class="text-sm text-slate-300">
                Attempt #{{ $attempt->attempt_number }} ·
                {{ $exam->is_timed ? "Timed ({$exam->duration_minutes} min)" : 'Untimed' }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form
            action="{{ route('student.exams.submit', [$exam, $attempt]) }}"
            method="POST"
            class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md space-y-6"
        >
            @csrf

            @foreach($answers as $index => $answer)
                @php
                    $question = $answer->question;
                    $qid = $question->id;
                @endphp

                <div class="border-b border-slate-800 pb-4 last:border-b-0 last:pb-0">
                    <p class="font-semibold mb-2 text-slate-100">
                        Q{{ $index + 1 }}.
                        {{ $question->question_text }}
                    </p>

                    <div class="space-y-2 text-sm">
                        @foreach(['a','b','c','d','e'] as $opt)
                            @php
                                $optionText = $question->{'option_'.$opt};
                            @endphp

                            @if($optionText)
                                <label class="flex items-start gap-2 bg-slate-800/60 border border-slate-700 hover:border-red-600 rounded-lg px-3 py-2 cursor-pointer transition">
                                    <input
                                        type="radio"
                                        name="answers[{{ $qid }}]"
                                        value="{{ $opt }}"
                                        class="mt-1 h-4 w-4 text-red-600"
                                        @checked(old("answers.$qid", $answer->selected_option) === $opt)
                                    >
                                    <span class="text-slate-200">
                                        <span class="font-semibold">{{ strtoupper($opt) }}.</span>
                                        {{ $optionText }}
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="pt-4 flex items-center justify-between">
                <a
                    href="{{ route('student.exams.show', $exam) }}"
                    class="text-sm text-red-300 hover:text-red-200 underline"
                >
                    ← Back to exam details
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center px-6 py-2 text-sm font-semibold bg-red-600 hover:bg-red-500 text-white rounded-lg shadow transition"
                >
                    Submit Exam
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
