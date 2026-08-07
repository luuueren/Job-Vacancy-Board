<nav x-data="{ open: false }" class="border-b border-gray-800 bg-gray-950">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            {{-- Left Side --}}
            <div class="flex h-full items-center">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center">
                    <x-application-logo class="block h-10 w-auto fill-current text-white" />
                </a>

                {{-- Navigation --}}
                <div class="ml-10 hidden h-full items-center gap-8 sm:flex">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                        class="relative flex h-full items-center px-1 text-sm font-medium transition
                        {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('Dashboard') }}

                        @if (request()->routeIs('dashboard'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500"></span>
                        @endif
                    </a>

                    {{-- My Applications --}}
                    <a href="{{ route('job-applications.index') }}"
                        class="relative flex h-full items-center px-1 text-sm font-medium transition
                        {{ request()->routeIs('job-applications.index') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('My Applications') }}

                        @if (request()->routeIs('job-applications.index'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500"></span>
                        @endif
                    </a>

                </div>

            </div>


            {{-- User Dropdown --}}
            <div class="hidden sm:flex sm:items-center">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-700 bg-gray-900 px-4 py-2 text-sm font-medium text-gray-200 transition hover:border-gray-600 hover:bg-gray-800 hover:text-white focus:outline-none">

                            <span>
                                {{ Auth::user()->name }}
                            </span>

                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>

                        </button>

                    </x-slot>


                    {{-- Dropdown Content --}}
                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            {{-- Mobile Button --}}
            <div class="flex items-center sm:hidden">

                <button @click="open = ! open" type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:bg-gray-800 hover:text-white focus:outline-none">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>

    </div>


    {{-- Mobile Navigation --}}
    <div x-cloak x-show="open" class="border-t border-gray-800 bg-gray-950 sm:hidden">

        <div class="space-y-1 px-4 pb-3 pt-3">

            <a href="{{ route('dashboard') }}"
                class="block rounded-lg px-3 py-2 text-sm font-medium
                {{ request()->routeIs('dashboard')
                    ? 'bg-gray-800 text-white'
                    : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('job-applications.index') }}"
                class="block rounded-lg px-3 py-2 text-sm font-medium
                {{ request()->routeIs('job-applications.index')
                    ? 'bg-gray-800 text-white'
                    : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                {{ __('My Applications') }}
            </a>

        </div>


        {{-- Mobile User --}}
        <div class="border-t border-gray-800 px-4 pb-4 pt-4">

            <div class="mb-3">

                <div class="text-base font-medium text-white">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-sm text-gray-400">
                    {{ Auth::user()->email }}
                </div>

            </div>

            <a href="{{ route('profile.edit') }}"
                class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-400 hover:bg-gray-800 hover:text-white">
                {{ __('Profile') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="mt-1 block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-400 hover:bg-gray-800 hover:text-white">
                    {{ __('Log Out') }}
                </button>

            </form>

        </div>

    </div>

</nav>
