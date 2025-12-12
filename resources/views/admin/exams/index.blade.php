<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manage Exams
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                View, edit, or delete available exams. Create new exams to assign questions.
            </p>

            <a
                href="{{ route('admin.exams.create') }}"
                class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm font-semibold rounded-lg shadow transition"
            >
                + Add New Exam
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-slate-900 border border-red-700 rounded-xl overflow-hidden shadow-md">
            @if($exams->isEmpty())
                <div class="p-6">
                    <p class="text-slate-300">No exams found.</p>
                </div>
            @else
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-950/60">
                        <tr class="text-slate-300">
                            <th class="px-4 py-3 text-left font-semibold">Title</th>
                            <th class="px-4 py-3 text-left font-semibold">Timed</th>
                            <th class="px-4 py-3 text-left font-semibold">Duration</th>
                            <th class="px-4 py-3 text-left font-semibold">Attempts</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @foreach($exams as $exam)
                            <tr class="text-slate-200">
                                <td class="px-4 py-3">
                                    {{ $exam->title }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $exam->is_timed ? 'Yes' : 'No' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $exam->is_timed ? ($exam->duration_minutes . ' min') : '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $exam->attempt_limit ? $exam->attempt_limit : 'Unlimited' }}
                                </td>

                                <td class="px-4 py-3 text-right space-x-3">
                                    <!-- Edit -->
                                    <a
                                        href="{{ route('admin.exams.edit', $exam) }}"
                                        class="text-red-300 hover:text-red-200 underline"
                                    >
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form
                                        action="{{ route('admin.exams.destroy', $exam) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Delete this exam?');"
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

    </div>
</x-app-layout>
