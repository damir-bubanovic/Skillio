<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skillio – Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen">
        <div class="max-w-5xl mx-auto py-10 px-4">
            <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>

            <p class="mb-2">
                Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }}).
            </p>

            <p class="mb-4">
                This is the starting point for managing questions, exams, users, and analytics in Skillio.
            </p>

            <div class="space-x-4">
                <a href="{{ route('dashboard') }}" class="underline text-blue-600">
                    Go to student dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="underline text-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
