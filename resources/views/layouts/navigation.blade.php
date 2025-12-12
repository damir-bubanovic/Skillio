<nav x-data="{ open: false }" class="bg-slate-950 border-b border-red-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo + main nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-8 w-8" />
                        <span class="text-lg font-semibold text-red-400 tracking-wide">
                            Skillio
                        </span>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 sm:space-x-6">
                    <!-- Dashboard (always) -->
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                    >
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Exams: admin vs student -->
                    @can('admin')
                        <x-nav-link
                            :href="route('admin.exams.index')"
                            :active="request()->routeIs('admin.exams.*')"
                        >
                            {{ __('Exams') }}
                        </x-nav-link>
                    @else
                        <x-nav-link
                            :href="route('student.exams.index')"
                            :active="request()->routeIs('student.exams.*')"
                        >
                            {{ __('Exams') }}
                        </x-nav-link>
                    @endcan

                    <!-- Student: Results (visible for all logged-in users) -->
                    <x-nav-link
                        :href="route('student.results.index')"
                        :active="request()->routeIs('student.results.*')"
                    >
                        {{ __('Results') }}
                    </x-nav-link>

                    <!-- Admin: Admin Panel -->
                    @can('admin')
                        <x-nav-link
                            :href="route('admin.dashboard')"
                            :active="request()->routeIs('admin.*')"
                        >
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Right: User dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Profile dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-slate-100 hover:text-red-300 focus:outline-none focus:text-red-300 transition"
                        >
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-slate-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-slate-700 my-1"></div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-200 hover:text-red-300 hover:bg-slate-900 focus:outline-none focus:bg-slate-900 focus:text-red-300 transition"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile nav menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-800 bg-slate-950">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard -->
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
            >
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Exams: admin vs student -->
            @can('admin')
                <x-responsive-nav-link
                    :href="route('admin.exams.index')"
                    :active="request()->routeIs('admin.exams.*')"
                >
                    {{ __('Exams') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link
                    :href="route('student.exams.index')"
                    :active="request()->routeIs('student.exams.*')"
                >
                    {{ __('Exams') }}
                </x-responsive-nav-link>
            @endcan

            <!-- Results -->
            <x-responsive-nav-link
                :href="route('student.results.index')"
                :active="request()->routeIs('student.results.*')"
            >
                {{ __('Results') }}
            </x-responsive-nav-link>

            <!-- Admin Panel -->
            @can('admin')
                <x-responsive-nav-link
                    :href="route('admin.dashboard')"
                    :active="request()->routeIs('admin.*')"
                >
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Mobile profile and logout -->
        <div class="pt-4 pb-1 border-t border-slate-800">
            <div class="px-4">
                <div class="font-medium text-base text-slate-100">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-slate-400">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
