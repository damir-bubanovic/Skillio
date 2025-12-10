<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exams – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-4">Available Exams</h1>

        <a href="{{ route('dashboard') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
            ← Back to dashboard
        </a>

        @if($exams->isEmpty())
            <p>No exams are currently available.</p>
        @else
            <div class="bg-white shadow rounded overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Timed</th>
                        <th class="px-4 py-2 text-left">Duration</th>
                        <th class="px-4 py-2 text-left">Attempts</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        @php
                            $count = $attemptsByExam[$exam->id] ?? 0;
                            $limit = $exam->attempt_limit;
                            $reachedLimit = !is_null($limit) && $count >= $limit;
                        @endphp
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $exam->title }}</td>
                            <td class="px-4 py-2">{{ $exam->is_timed ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2">
                                {{ $exam->is_timed ? ($exam->duration_minutes . ' min') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $count }}{{ $limit ? " / $limit" : ' / ∞' }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('student.exams.show', $exam) }}"
                                   class="text-sm underline text-blue-600">
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
</div>
</body>
</html>
