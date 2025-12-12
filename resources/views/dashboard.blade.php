<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome area -->
        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
            <h3 class="text-2xl font-semibold text-red-400 mb-3">
                Welcome, {{ Auth::user()->name }}
            </h3>
            <p class="text-slate-300">
                This is your dashboard. Use the navigation menu to access exams, results,
                and other sections of the platform.
            </p>
        </div>

        <!-- Quick actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Exams -->
            <a
                href="{{ route('student.exams.index') }}"
                class="bg-slate-900 border border-red-700 rounded-xl p-6 hover:bg-slate-800 transition shadow-md"
            >
                <h4 class="text-xl font-semibold text-red-400 mb-2">Exams</h4>
                <p class="text-slate-300">
                    View available exams and start practicing.
                </p>
            </a>

            <!-- Results -->
            <a
                href="{{ route('student.results.index') }}"
                class="bg-slate-900 border border-red-700 rounded-xl p-6 hover:bg-slate-800 transition shadow-md"
            >
                <h4 class="text-xl font-semibold text-red-400 mb-2">Results</h4>
                <p class="text-slate-300">
                    Track your performance and see past outcomes.
                </p>
            </a>

            <!-- Admin Panel -->
            @can('admin')
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="bg-slate-900 border border-red-700 rounded-xl p-6 hover:bg-slate-800 transition shadow-md"
                >
                    <h4 class="text-xl font-semibold text-red-400 mb-2">Admin Panel</h4>
                    <p class="text-slate-300">
                        Manage exams, users, questions, and settings.
                    </p>
                </a>
            @endcan
        </div>
    </div>
</x-app-layout>
