<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Exam – {{ $exam->title }} – Skillio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-2">{{ $exam->title }}</h1>
        <p class="text-sm text-gray-600 mb-4">
            Attempt #{{ $attempt->attempt_number }} •
            {{ $exam->is_timed ? "Timed ({$exam->duration_minutes} min)" : 'Untimed' }}
        </p>

        <form action="{{ route('student.exams.submit', [$exam, $attempt]) }}" method="POST"
              class="bg-white shadow rounded px-4 py-6 space-y-6">
            @csrf

            @foreach($answers as $index => $answer)
                @php
                    $question = $answer->question;
                    $qid = $question->id;
                @endphp

                <div class="border-b pb-4">
                    <p class="font-semibold mb-2">
                        Q{{ $index + 1 }}.
                        {{ $question->question_text }}
                    </p>

                    <div class="space-y-1 text-sm">
                        @foreach(['a','b','c','d','e'] as $opt)
                            @php
                                $optionText = $question->{'option_'.$opt};
                            @endphp
                            @if($optionText)
                                <label class="flex items-center space-x-2">
                                    <input type="radio"
                                           name="answers[{{ $qid }}]"
                                           value="{{ $opt }}"
                                           @checked(old("answers.$qid", $answer->selected_option) === $opt)>
                                    <span>{{ strtoupper($opt) }}. {{ $optionText }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="pt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded shadow">
                    Submit Exam
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
