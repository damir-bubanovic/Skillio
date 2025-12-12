<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('My Exam Results') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                Here you can review all your previous exam attempts and scores.
            </p>

            <a
                href="{{ route('student.results.topics') }}"
                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full border border-red-600 text-red-300 hover:bg-red-600/10 transition"
            >
                Topic performance
            </a>
        </div>

        @if($attempts->isEmpty())
            <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
                <p class="text-slate-300">
                    You have not completed any exams yet.
                </p>
                <a
                    href="{{ route('student.exams.index') }}"
                    class="mt-3 inline-block text-sm text-red-300 hover:text-red-200 underline"
                >
                    Go to exams →
                </a>
            </div>
        @else
            <div class="bg-slate-900 border border-red-700 rounded-xl overflow-hidden shadow-md">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/60">
                        <tr class="text-slate-300">
                            <th class="px-4 py-3 text-left font-semibold">Exam</th>
                            <th class="px-4 py-3 text-left font-semibold">Attempt</th>
                            <th class="px-4 py-3 text-left font-semibold">Score</th>
                            <th class="px-4 py-3 text-left font-semibold">Percentage</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-right font-semibold">Completed</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($attempts as $attempt)
                            <tr class="text-slate-200">
                                <td class="px-4 py-3">
                                    {{ $attempt->exam->title }}
                                </td>
                                <td class="px-4 py-3">
                                    #{{ $attempt->attempt_number }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $attempt->score }}
                                    <span class="text-slate-400">/ {{ $attempt->total_questions }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $attempt->percentage }}%
                                </td>
                                <td class="px-4 py-3">
                                    @if($attempt->status === 'completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-900/40 text-green-300 border border-green-700">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-900/40 text-yellow-300 border border-yellow-700">
                                            In progress
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-slate-300">
                                    {{ $attempt->completed_at ?? $attempt->created_at }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a
                                        href="{{ route('student.exams.result', [$attempt->exam, $attempt]) }}"
                                        class="text-sm font-semibold text-red-300 hover:text-red-200 underline"
                                    >
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-6">
            <a
                href="{{ route('dashboard') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                ← Back to dashboard
            </a>
        </div>
    </div>
</x-app-layout>
