<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Result – {{ $exam->title }} – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-2">{{ $exam->title }} – Result</h1>
        <p class="text-sm text-gray-600 mb-4">
            Attempt #{{ $attempt->attempt_number }}
        </p>

        <div class="bg-white shadow rounded px-4 py-4 mb-6">
            <p class="text-sm">
                <strong>Score:</strong> {{ $attempt->score }} / {{ $attempt->total_questions }}
            </p>
            <p class="text-sm">
                <strong>Percentage:</strong> {{ $attempt->percentage }}%
            </p>
            <p class="text-sm">
                <strong>Correct:</strong> {{ $attempt->correct_count }} •
                <strong>Incorrect:</strong> {{ $attempt->incorrect_count }} •
                <strong>Skipped:</strong> {{ $attempt->skipped_count }}
            </p>
            <p class="text-sm">
                <strong>Started:</strong> {{ $attempt->started_at?->format('Y-m-d H:i') }} •
                <strong>Completed:</strong> {{ $attempt->completed_at?->format('Y-m-d H:i') }}
            </p>
        </div>

        <h2 class="text-xl font-semibold mb-3">Questions & Answers</h2>

        <div class="bg-white shadow rounded px-4 py-4 space-y-4">
            @foreach($attempt->answers as $index => $answer)
                @php
                    $question = $answer->question;
                @endphp
                <div class="border-b pb-3">
                    <p class="font-semibold mb-1">
                        Q{{ $index + 1 }}. {{ $question->question_text }}
                    </p>
                    <p class="text-sm mb-1">
                        <strong>Your answer:</strong>
                        @if($answer->selected_option)
                            {{ strtoupper($answer->selected_option) }}
                        @else
                            <span class="text-gray-500">Not answered</span>
                        @endif
                    </p>
                    <p class="text-sm mb-1">
                        <strong>Correct answer:</strong> {{ strtoupper($question->correct_option) }}
                    </p>
                    <p class="text-sm mb-1">
                        <strong>Result:</strong>
                        @if($answer->selected_option === $question->correct_option)
                            <span class="text-green-600">Correct</span>
                        @elseif(!$answer->selected_option)
                            <span class="text-gray-600">Skipped</span>
                        @else
                            <span class="text-red-600">Incorrect</span>
                        @endif
                    </p>
                    @if($question->explanation)
                        <p class="text-sm text-gray-700">
                            <strong>Explanation:</strong> {{ $question->explanation }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('student.exams.index') }}" class="text-sm underline text-blue-600">
                Back to exams
            </a>
        </div>
    </div>
</div>
</body>
</html>
