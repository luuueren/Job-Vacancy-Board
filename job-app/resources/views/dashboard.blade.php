<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            Job Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Welcome --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-white">
                    Welcome, {{ auth()->user()->name }}
                </h1>

                <p class="mt-2 text-gray-400">
                    Find your next opportunity.
                </p>

            </div>

            {{-- Search --}}
            {{-- Search & Filters --}}
            <form method="GET" action="{{ route('dashboard') }}" class="mb-10">

                <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5">

                    <div class="grid gap-4 lg:grid-cols-[1fr_220px_auto]">

                        {{-- Search --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-300">
                                Search
                            </label>

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by job title, company or location..."
                                class="w-full rounded-lg border border-zinc-700 bg-black px-4 py-3 text-white placeholder:text-gray-500 focus:border-indigo-500 focus:ring-indigo-500">

                        </div>

                        {{-- Job Type --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-300">
                                Job Type
                            </label>

                            <select name="type"
                                class="w-full rounded-lg border border-zinc-700 bg-black px-4 py-3 text-white focus:border-indigo-500 focus:ring-indigo-500">

                                <option value="">All Types</option>

                                <option value="Full-Time" {{ request('type') == 'Full-Time' ? 'selected' : '' }}>
                                    Full Time
                                </option>

                                <option value="Contract" {{ request('type') == 'Contract' ? 'selected' : '' }}>
                                    Contract
                                </option>

                                <option value="Remote" {{ request('type') == 'Remote' ? 'selected' : '' }}>
                                    Remote
                                </option>

                                <option value="Hybrid" {{ request('type') == 'Hybrid' ? 'selected' : '' }}>
                                    Hybrid
                                </option>

                            </select>

                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-end gap-2">

                            <button type="submit"
                                class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-700">

                                Search

                            </button>

                            <a href="{{ route('dashboard') }}"
                                class="rounded-lg border border-zinc-700 px-6 py-3 text-white hover:bg-zinc-800">

                                Clear

                            </a>

                        </div>

                    </div>

                </div>

            </form>

            {{-- Jobs --}}

            <div class="space-y-5">

                @forelse($jobs as $job)
                    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-6 hover:border-indigo-500 transition">

                        <div class="flex justify-between items-start">

                            <div class="flex-1">

                                <h2 class="text-2xl font-bold text-white">
                                    {{ $job->title }}
                                </h2>

                                <div class="mt-5 flex flex-wrap gap-6 text-sm">

                                    <div class="text-gray-300">

                                        🏢 <span class="font-semibold">Company:</span>

                                        {{ $job->company?->name }}

                                    </div>

                                    <div class="text-gray-400">

                                        📍 <span class="font-semibold">Location:</span>

                                        {{ $job->location }}

                                    </div>

                                </div>

                                <p class="mt-5 text-lg font-bold text-green-400">

                                    ${{ number_format($job->salary, 2) }}

                                </p>

                            </div>

                            @php

                                $badge = match ($job->type) {
                                    'Full-Time' => 'bg-green-600',

                                    'Contract' => 'bg-orange-600',

                                    'Remote' => 'bg-blue-600',

                                    'Hybrid' => 'bg-purple-600',

                                    default => 'bg-gray-600',
                                };

                            @endphp

                            <span
                                class="{{ $badge }} self-start rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wide text-white shadow">

                                {{ $job->type }}

                            </span>

                        </div>

                        <div class="mt-6 flex justify-end">

                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                class="rounded-lg bg-indigo-600 px-5 py-2 font-semibold text-white transition hover:bg-indigo-700">

                                View Details →
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl bg-zinc-900 p-10 text-center">

                        <h3 class="text-xl font-semibold text-white">
                            No jobs available
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Please check back later.
                        </p>

                    </div>
                @endforelse

            </div>

            <div class="mt-8">

                {{ $jobs->links() }}

            </div>

        </div>
    </div>

</x-app-layout>
