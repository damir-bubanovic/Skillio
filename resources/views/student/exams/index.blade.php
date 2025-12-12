<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Available Exams') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                Choose an exam to start practicing. Your attempt limits are shown for each exam.
            </p>

            <a
                href="{{ route('dashboard') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                ← Back to dashboard
            </a>
        </div>

        @if($exams->isEmpty())
            <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
                <p class="text-slate-300">
                    No exams are currently available.
                </p>
            </div>
        @else
            <div class="bg-slate-900 border border-red-700 rounded-xl overflow-hidden shadow-md">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/60">
                        <tr class="text-slate-300">
                            <th class="px-4 py-3 text-left font-semibold">Title</th>
                            <th class="px-4 py-3 text-left font-semibold">Timed</th>
                            <th class="px-4 py-3 text-left font-semibold">Duration</th>
                            <th class="px-4 py-3 text-left font-semibold">Attempts</th>
                            <th class="px-4 py-3 text-right font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($exams as $exam)
                            @php
                                $count = $attemptsByExam[$exam->id] ?? 0;
                                $limit = $exam->attempt_limit;
                                $reachedLimit = !is_null($limit) && $count >= $limit;
                            @endphp
                            <tr class="text-slate-200">
                                <td class="px-4 py-3">
                                    {{ $exam->title }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $exam->is_timed ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $exam->is_timed ? ($exam->duration_minutes . ' min') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="{{ $reachedLimit ? 'text-red-400 font-semibold' : '' }}">
                                        {{ $count }}{{ $limit ? " / $limit" : ' / ∞' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a
                                        href="{{ route('student.exams.show', $exam) }}"
                                        class="text-sm font-semibold text-red-300 hover:text-red-200 underline"
                                    >
                                        View details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
