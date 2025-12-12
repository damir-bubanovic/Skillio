<x-app-layout>

    @php
        // Compute limit status here so controller doesn't need modification
        $limit = $exam->attempt_limit;
        $attemptLimitReached = $limit !== null && $attemptCount >= $limit;
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">

            <!-- Exam info -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-red-300 mb-3">Exam Details</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-slate-300 text-sm">
                    <div>
                        <span class="font-semibold text-slate-200">Timed:</span>
                        {{ $exam->is_timed ? 'Yes' : 'No' }}
                    </div>

                    <div>
                        <span class="font-semibold text-slate-200">Duration:</span>
                        {{ $exam->is_timed ? ($exam->duration_minutes . ' minutes') : 'No time limit' }}
                    </div>

                    <div>
                        <span class="font-semibold text-slate-200">Attempt Limit:</span>
                        {{ $exam->attempt_limit ? $exam->attempt_limit : 'Unlimited' }}
                    </div>

                    <div>
                        <span class="font-semibold text-slate-200">Your Attempts:</span>
                        {{ $attemptCount }}
                    </div>
                </div>
            </div>

            <!-- Message for attempt limit -->
            @if($attemptLimitReached)
                <div class="bg-red-900/40 border border-red-700 rounded-lg p-4 mb-6">
                    <p class="text-red-300">
                        You have reached the maximum number of attempts for this exam.
                    </p>
                </div>
            @endif

            <!-- Start exam button -->
            <div class="flex items-center justify-between mt-6">
                <a
                    href="{{ route('student.exams.index') }}"
                    class="text-sm text-red-300 hover:text-red-200 underline"
                >
                    ← Back to exams
                </a>

                @if(!$attemptLimitReached)
                    <form action="{{ route('student.exams.start', $exam) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="px-6 py-2 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg shadow transition"
                        >
                            Start Exam
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
