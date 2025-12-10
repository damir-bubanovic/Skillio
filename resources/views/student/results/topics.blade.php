<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Topic Performance – Skillio</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen max-w-4xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-bold mb-4">Topic Performance</h1>

    <a href="{{ route('student.results.index') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
        ← Back to results
    </a>

    @if(empty($summary))
        <p>No completed answers yet.</p>
    @else
        @foreach($summary as $category => $stats)
            <div class="bg-white shadow rounded px-4 py-4 mb-4">
                <h2 class="text-lg font-semibold mb-1">{{ $category }}</h2>
                <p class="text-sm">Total questions: {{ $stats['total'] }}</p>
                <p class="text-sm">Correct: {{ $stats['correct'] }}</p>
                <p class="text-sm">Accuracy: {{ $stats['percentage'] }}%</p>
            </div>
        @endforeach
    @endif

</div>
</body>
</html>
