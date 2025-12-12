<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Skillio') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-950 text-slate-100">
        <div class="min-h-screen flex flex-col">
            <!-- Top bar with login/register -->
            <header class="px-6 py-4 flex justify-between items-center border-b border-red-700 bg-slate-950/80">
                <div class="flex items-center gap-3">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Skillio logo"
                        class="h-10 w-10"
                    >
                    <span class="text-xl font-semibold text-red-400 tracking-wide">
                        Skillio
                    </span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="text-sm font-medium text-slate-200 hover:text-red-300"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="text-sm font-medium text-slate-200 hover:text-red-300"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-500 text-white shadow transition"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <!-- Hero section -->
            <main class="flex-1 flex items-center">
                <div class="max-w-5xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                            Practice. Improve. Master your skills with
                            <span class="text-red-400">Skillio</span>.
                        </h1>
                        <p class="text-slate-300 mb-8">
                            Skillio helps students prepare for exams, track progress, and
                            grow their knowledge through structured practice and instant feedback.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            @auth
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-6 py-3 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-500 text-white shadow-lg transition"
                                >
                                    Go to Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center px-6 py-3 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-500 text-white shadow-lg transition"
                                >
                                    Get Started
                                </a>
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex items-center px-6 py-3 rounded-lg text-sm font-semibold border border-red-600 text-red-300 hover:bg-red-600/10 transition"
                                >
                                    I already have an account
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Feature cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-900 border border-red-700 rounded-xl p-4 shadow-md">
                            <h3 class="text-lg font-semibold text-red-300 mb-1">Exam Practice</h3>
                            <p class="text-slate-300 text-sm">
                                Access exams tailored to your skills and practice at your own pace.
                            </p>
                        </div>
                        <div class="bg-slate-900 border border-red-700 rounded-xl p-4 shadow-md">
                            <h3 class="text-lg font-semibold text-red-300 mb-1">Instant Feedback</h3>
                            <p class="text-slate-300 text-sm">
                                See your results immediately and understand where you can improve.
                            </p>
                        </div>
                        <div class="bg-slate-900 border border-red-700 rounded-xl p-4 shadow-md">
                            <h3 class="text-lg font-semibold text-red-300 mb-1">Progress Tracking</h3>
                            <p class="text-slate-300 text-sm">
                                Monitor performance over time and stay motivated.
                            </p>
                        </div>
                        <div class="bg-slate-900 border border-red-700 rounded-xl p-4 shadow-md">
                            <h3 class="text-lg font-semibold text-red-300 mb-1">Admin Control</h3>
                            <p class="text-slate-300 text-sm">
                                Manage exams, questions, and users from a powerful admin panel.
                            </p>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 text-center text-xs text-slate-500 border-t border-slate-800">
                &copy; {{ date('Y') }} Skillio. All rights reserved.
            </footer>
        </div>
    </body>
</html>
