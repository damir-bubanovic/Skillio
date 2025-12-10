<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Available exams --}}
                <a href="{{ route('student.exams.index') }}"
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Available Exams</h3>
                        <p class="text-sm text-gray-600">
                            Browse and start mock exams assigned in Skillio.
                        </p>
                    </div>
                </a>

                {{-- My results --}}
                <a href="{{ route('student.results.index') }}"
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">My Results</h3>
                        <p class="text-sm text-gray-600">
                            Review all your past attempts with scores and details.
                        </p>
                    </div>
                </a>

                {{-- Topic performance --}}
                <a href="{{ route('student.results.topics') }}"
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Topic Performance</h3>
                        <p class="text-sm text-gray-600">
                            See your strengths and weaknesses by topic/category.
                        </p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
