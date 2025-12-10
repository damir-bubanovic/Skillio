<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skillio – Questions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Questions</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="text-sm underline text-gray-700">Admin dashboard</a>
                <a href="{{ route('admin.questions.create') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    + New Question
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if($questions->isEmpty())
            <p>No questions yet.</p>
        @else
            <div class="bg-white shadow rounded overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Question</th>
                        <th class="px-4 py-2 text-left">Category</th>
                        <th class="px-4 py-2 text-left">Difficulty</th>
                        <th class="px-4 py-2 text-left">Created</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $question->id }}</td>
                            <td class="px-4 py-2 max-w-md truncate">{{ Str::limit($question->question_text, 80) }}</td>
                            <td class="px-4 py-2">{{ $question->category ?? '-' }}</td>
                            <td class="px-4 py-2 capitalize">{{ $question->difficulty }}</td>
                            <td class="px-4 py-2 text-xs text-gray-500">{{ $question->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('admin.questions.edit', $question) }}"
                                   class="text-blue-600 underline text-xs">Edit</a>

                                <form action="{{ route('admin.questions.destroy', $question) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this question?');">
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
                {{ $questions->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>
