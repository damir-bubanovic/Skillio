<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-slate-900 border border-red-700 rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold text-red-300 mb-4">Welcome, Admin</h3>

            <p class="text-slate-300 mb-6">
                Manage exams, questions, and review platform statistics.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Exams -->
                <a
                    href="{{ route('admin.exams.index') }}"
                    class="bg-slate-900 border border-red-700 rounded-xl p-5 hover:bg-slate-800 transition shadow"
                >
                    <h4 class="text-xl font-semibold text-red-400 mb-2">Exams</h4>
                    <p class="text-slate-300 text-sm">
                        Create, edit, and manage exams.
                    </p>
                </a>

                <!-- Questions -->
                <a
                    href="{{ route('admin.questions.index') }}"
                    class="bg-slate-900 border border-red-700 rounded-xl p-5 hover:bg-slate-800 transition shadow"
                >
                    <h4 class="text-xl font-semibold text-red-400 mb-2">Questions</h4>
                    <p class="text-slate-300 text-sm">
                        Add and update question bank items.
                    </p>
                </a>

                <!-- Question Stats -->
                <a
                    href="{{ route('admin.stats.questions') }}"
                    class="bg-slate-900 border border-red-700 rounded-xl p-5 hover:bg-slate-800 transition shadow"
                >
                    <h4 class="text-xl font-semibold text-red-400 mb-2">Question Stats</h4>
                    <p class="text-slate-300 text-sm">
                        See attempts, correct counts, and difficulty.
                    </p>
                </a>

                <!-- Users (only if route exists; remove if you don't have it) -->
                @if(\Illuminate\Support\Facades\Route::has('admin.users.index'))
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="bg-slate-900 border border-red-700 rounded-xl p-5 hover:bg-slate-800 transition shadow"
                    >
                        <h4 class="text-xl font-semibold text-red-400 mb-2">Users</h4>
                        <p class="text-slate-300 text-sm">
                            Manage accounts and roles.
                        </p>
                    </a>
                @endif

                <!-- Attempts (only if route exists; remove if you don't have it) -->
                @if(\Illuminate\Support\Facades\Route::has('admin.attempts.index'))
                    <a
                        href="{{ route('admin.attempts.index') }}"
                        class="bg-slate-900 border border-red-700 rounded-xl p-5 hover:bg-slate-800 transition shadow"
                    >
                        <h4 class="text-xl font-semibold text-red-400 mb-2">Attempts</h4>
                        <p class="text-slate-300 text-sm">
                            Review student exam attempts.
                        </p>
                    </a>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
