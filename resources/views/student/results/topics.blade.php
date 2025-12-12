<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Topic Performance') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-sm text-slate-400 mb-6">
            Your results grouped by topic. Review strengths and weaknesses to improve your performance.
        </p>

        @if(empty($summary))
            <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
                <p class="text-slate-300">
                    You do not have any topic performance data yet.
                </p>
                <a
                    href="{{ route('student.exams.index') }}"
                    class="mt-3 inline-block text-sm text-red-300 hover:text-red-200 underline"
                >
                    Take an exam →
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($summary as $category => $stats)
                    @php
                        $percentage = $stats['percentage'] ?? 0;
                        $badgeClass =
                            $percentage >= 70 ? 'bg-green-900/40 text-green-300 border border-green-700' :
                            ($percentage >= 40 ? 'bg-yellow-900/40 text-yellow-300 border border-yellow-700' :
                                                 'bg-red-900/40 text-red-300 border border-red-700');
                    @endphp

                    <div class="bg-slate-900 border border-red-700 rounded-xl p-5 shadow-md">
                        <h3 class="text-lg font-semibold text-red-300 mb-2">
                            {{ $category }}
                        </h3>

                        <p class="text-sm text-slate-300 mb-1">
                            <span class="font-semibold text-slate-200">Total questions:</span>
                            {{ $stats['total'] }}
                        </p>

                        <p class="text-sm text-slate-300 mb-1">
                            <span class="font-semibold text-slate-200">Correct:</span>
                            {{ $stats['correct'] }}
                        </p>

                        <p class="mt-3">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                {{ $percentage }}%
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a
                href="{{ route('student.results.index') }}"
                class="text-sm text-red-300 hover:text-red-200 underline"
            >
                ← Back to results
            </a>
        </div>
    </div>
</x-app-layout>
