<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skillio – Exams</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Exams</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="text-sm underline text-gray-700">Admin dashboard</a>
                <a href="{{ route('admin.exams.create') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    + New Exam
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if($exams->isEmpty())
            <p>No exams yet.</p>
        @else
            <div class="bg-white shadow rounded overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Timed</th>
                        <th class="px-4 py-2 text-left">Duration</th>
                        <th class="px-4 py-2 text-left">Attempts</th>
                        <th class="px-4 py-2 text-left">Active</th>
                        <th class="px-4 py-2 text-left">Created</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $exam->id }}</td>
                            <td class="px-4 py-2">{{ $exam->title }}</td>
                            <td class="px-4 py-2">
                                {{ $exam->is_timed ? 'Yes' : 'No' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $exam->is_timed ? ($exam->duration_minutes . ' min') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $exam->attempt_limit ?? 'Unlimited' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $exam->is_active ? 'Active' : 'Inactive' }}
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-500">
                                {{ $exam->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('admin.exams.edit', $exam) }}"
                                   class="text-blue-600 underline text-xs">Edit</a>
                                <form action="{{ route('admin.exams.destroy', $exam) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this exam?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 underline text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $exams->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>
