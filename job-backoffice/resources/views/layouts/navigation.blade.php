<nav class="w-[250px] h-screen border-r border-gray-200 bg-white">

    {{-- Logo --}}
    <div class="flex items-center border-b border-gray-200 px-6 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">
                {{ __('Shaghalni') }}
            </span>
        </a>
    </div>

    {{-- Navigation --}}
    <ul class="flex flex-col space-y-4 px-4 py-6">

        {{-- Dashboard --}}
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">

            {{ __('Dashboard') }}

        </x-nav-link>

        {{-- ========================= --}}
        {{-- Admin Navigation --}}
        {{-- ========================= --}}
        @if (auth()->user()->role === 'admin')
            <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.*')">

                {{ __('Companies') }}

            </x-nav-link>

            <x-nav-link :href="route('application.index')" :active="request()->routeIs('application.*')">

                {{ __('Job Applications') }}

            </x-nav-link>

            <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.*')">

                {{ __('Categories') }}

            </x-nav-link>

            <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.*')">

                {{ __('Job Vacancies') }}

            </x-nav-link>

            <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">

                {{ __('Users') }}

            </x-nav-link>
        @endif


        {{-- ========================= --}}
        {{-- Company Owner Navigation --}}
        {{-- ========================= --}}
        @if (auth()->user()->role === 'company-owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">

                {{ __('My Company') }}

            </x-nav-link>

            <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.*')">

                {{ __('Job Vacancies') }}

            </x-nav-link>

            <x-nav-link :href="route('application.index')" :active="request()->routeIs('application.*')">

                {{ __('Job Applications') }}

            </x-nav-link>
        @endif

        <hr>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-nav-link class="text-red-500" :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">

                {{ __('Log Out') }}

            </x-nav-link>

        </form>

    </ul>

</nav>
