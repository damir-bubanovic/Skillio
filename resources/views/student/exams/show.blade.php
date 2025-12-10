<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->title }} – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-2">{{ $exam->title }}</h1>

        <a href="{{ route('student.exams.index') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
            ← Back to exams
        </a>

        @if(session('status'))
            <div class="mb-4 px-4 py-2 bg-yellow-100 text-yellow-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white shadow rounded px-4 py-4 space-y-2 mb-4">
            @if($exam->description)
                <p class="text-sm">{{ $exam->description }}</p>
            @endif

            <p class="text-sm">
                <strong>Timed:</strong>
                {{ $exam->is_timed ? 'Yes' : 'No' }}
                @if($exam->is_timed)
                    ({{ $exam->duration_minutes }} minutes)
                @endif
            </p>

            <p class="text-sm">
                <strong>Attempt limit:</strong>
                {{ $exam->attempt_limit ? $exam->attempt_limit : 'Unlimited' }}
            </p>

            <p class="text-sm">
                <strong>Your attempts:</strong> {{ $attemptCount }}
            </p>
        </div>

        @php
            $reachedLimit = !is_null($exam->attempt_limit) && $attemptCount >= $exam->attempt_limit;
        @endphp

        @if($reachedLimit)
            <p class="text-sm text-red-600">
                You have reached the maximum number of attempts for this exam.
            </p>
        @else
            <form action="{{ route('student.exams.start', $exam) }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    Start Exam
                </button>
            </form>
        @endif
    </div>
</div>
</body>
</html>
