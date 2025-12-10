<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question Statistics – Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen max-w-6xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-bold mb-4">Question Statistics</h1>

    <a href="{{ route('admin.dashboard') }}" class="text-sm underline text-gray-700 mb-4 inline-block">
        ← Back to admin dashboard
    </a>

    @if($stats->isEmpty())
        <p>No data available yet.</p>
    @else
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Question</th>
                        <th class="px-4 py-2 text-left">Attempts</th>
                        <th class="px-4 py-2 text-left">Correct</th>
                        <th class="px-4 py-2 text-left">Difficulty (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats as $row)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ $questions[$row->question_id]->question_text ?? 'Question deleted' }}
                            </td>
                            <td class="px-4 py-2">{{ $row->attempts }}</td>
                            <td class="px-4 py-2">{{ $row->correct }}</td>
                            <td class="px-4 py-2">{{ $row->difficulty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
</body>
</html>
