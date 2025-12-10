<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Results – Skillio</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen max-w-5xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-bold mb-4">My Exam Results</h1>

    <a href="{{ route('dashboard') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
        ← Back to dashboard
    </a>

    @if($attempts->isEmpty())
        <p>You haven't completed any exams yet.</p>
    @else
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Exam</th>
                        <th class="px-4 py-2 text-left">Score</th>
                        <th class="px-4 py-2 text-left">Percentage</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attempts as $attempt)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $attempt->exam->title }}</td>
                            <td class="px-4 py-2">{{ $attempt->score }}/{{ $attempt->total_questions }}</td>
                            <td class="px-4 py-2">{{ $attempt->percentage }}%</td>
                            <td class="px-4 py-2">{{ $attempt->completed_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('student.exams.result', [$attempt->exam, $attempt]) }}"
                                   class="text-sm underline text-blue-600">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
</body>
</html>
