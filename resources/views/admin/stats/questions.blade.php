<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Question Statistics
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                Overview of how questions perform across attempts.
            </p>

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                ← Back to admin dashboard
            </a>
        </div>

        <div class="bg-slate-900 border border-red-700 rounded-xl overflow-hidden shadow-md">
            @if($stats->isEmpty())
                <div class="p-6">
                    <p class="text-slate-300">No data available yet.</p>
                </div>
            @else
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/60">
                        <tr class="text-slate-300">
                            <th class="px-4 py-3 text-left font-semibold">Question</th>
                            <th class="px-4 py-3 text-left font-semibold">Attempts</th>
                            <th class="px-4 py-3 text-left font-semibold">Correct</th>
                            <th class="px-4 py-3 text-left font-semibold">Difficulty (%)</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @foreach($stats as $row)
                            @php
                                $qText = $questions[$row->question_id]->question_text ?? 'Question deleted';
                                $difficulty = $row->difficulty;
                            @endphp

                            <tr class="text-slate-200 align-top">
                                <td class="px-4 py-3">
                                    <div class="text-slate-100 font-semibold">
                                        {{ \Illuminate\Support\Str::limit($qText, 140) }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    {{ $row->attempts }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $row->correct }}
                                </td>

                                <td class="px-4 py-3">
                                    @php
                                        $badge =
                                            $difficulty >= 70 ? 'bg-red-900/40 text-red-200 border border-red-700' :
                                            ($difficulty >= 40 ? 'bg-yellow-900/40 text-yellow-200 border border-yellow-700' :
                                                                'bg-green-900/40 text-green-200 border border-green-700');
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                                        {{ $difficulty }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>
