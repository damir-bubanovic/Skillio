<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skillio – Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-1">Admin Dashboard</h1>
                <p class="text-sm text-gray-600">
                    Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }}).
                </p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded shadow">
                    Logout
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Questions --}}
            <a href="{{ route('admin.questions.index') }}"
               class="block bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Question Bank</h2>
                <p class="text-sm text-gray-600 mb-2">
                    Add, edit, or delete questions, including explanations and difficulty.
                </p>
                <span class="text-sm text-blue-600 underline">Manage questions</span>
            </a>

            {{-- Exams --}}
            <a href="{{ route('admin.exams.index') }}"
               class="block bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Exams</h2>
                <p class="text-sm text-gray-600 mb-2">
                    Create exam sets, configure timing, and attach questions.
                </p>
                <span class="text-sm text-blue-600 underline">Manage exams</span>
            </a>

            {{-- Stats --}}
            <a href="{{ route('admin.stats.questions') }}"
               class="block bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Question Statistics</h2>
                <p class="text-sm text-gray-600 mb-2">
                    View difficulty index and performance statistics for each question.
                </p>
                <span class="text-sm text-blue-600 underline">View analytics</span>
            </a>

        </div>
    </div>
</div>
</body>
</html>
