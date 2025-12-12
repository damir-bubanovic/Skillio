<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manage Questions
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
            <p class="text-sm text-slate-400">
                Create and manage questions used in exams.
            </p>

            <a
                href="{{ route('admin.questions.create') }}"
                class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm font-semibold rounded-lg shadow transition"
            >
                + Add New Question
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-slate-900 border border-red-700 rounded-xl overflow-hidden shadow-md">
            @if($questions->isEmpty())
                <div class="p-6">
                    <p class="text-slate-300">No questions found.</p>
                </div>
            @else
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/60">
                        <tr class="text-slate-300">
                            <th class="px-4 py-3 text-left font-semibold">ID</th>
                            <th class="px-4 py-3 text-left font-semibold">Question</th>
                            <th class="px-4 py-3 text-left font-semibold">Category</th>
                            <th class="px-4 py-3 text-left font-semibold">Correct</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @foreach($questions as $question)
                            <tr class="text-slate-200 align-top">
                                <td class="px-4 py-3">
                                    #{{ $question->id }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-100">
                                        {{ \Illuminate\Support\Str::limit($question->question_text, 110) }}
                                    </div>
                                    <div class="mt-1 text-xs text-slate-400">
                                        Options:
                                        {{ $question->option_a ? 'A' : '' }}
                                        {{ $question->option_b ? 'B' : '' }}
                                        {{ $question->option_c ? 'C' : '' }}
                                        {{ $question->option_d ? 'D' : '' }}
                                        {{ $question->option_e ? 'E' : '' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-slate-300">
                                    {{ $question->category->name ?? '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border border-slate-600 text-slate-200">
                                        {{ strtoupper($question->correct_option) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                                    <a
                                        href="{{ route('admin.questions.edit', $question) }}"
                                        class="text-red-300 hover:text-red-200 underline"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.questions.destroy', $question) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Delete this question?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-400 hover:text-red-300 underline"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if(method_exists($questions, 'links'))
            <div class="mt-6">
                {{ $questions->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
