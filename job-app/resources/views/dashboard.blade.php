<x-app-layout>

    <x-slot name="header">
        <div class="bg-zinc-950">
            <div class="mx-auto max-w-7xl px-6 py-5">
                <h2 class="text-xl font-semibold text-white">
                    Job Dashboard
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- Dashboard Content --}}
    <div class="min-h-screen bg-zinc-950 py-10">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Welcome Section --}}
            <div class="mb-10">

                <h1 class="text-4xl font-bold tracking-tight text-white">
                    Welcome, {{ auth()->user()->name }}
                </h1>

                <p class="mt-3 text-lg text-zinc-400">
                    Find your next opportunity.
                </p>

            </div>


            {{-- Search & Filters --}}
            <form method="GET" action="{{ route('dashboard') }}" class="mb-10">

                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/80 p-6 shadow-xl">

                    <div class="grid gap-5 lg:grid-cols-[1fr_220px_auto]">

                        {{-- Search --}}
                        <div>

                            <label for="search" class="mb-2 block text-sm font-semibold text-zinc-300">
                                Search
                            </label>

                            <input id="search" type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by job title, company or location..."
                                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3.5 text-white placeholder-zinc-500 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">

                        </div>


                        {{-- Job Type --}}
                        <div>

                            <label for="type" class="mb-2 block text-sm font-semibold text-zinc-300">
                                Job Type
                            </label>

                            <select id="type" name="type"
                                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3.5 text-white outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">

                                <option value="">
                                    All Types
                                </option>

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
                        <div class="flex items-end gap-3">

                            <button type="submit"
                                class="rounded-xl bg-indigo-600 px-7 py-3.5 font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-zinc-900">
                                Search
                            </button>

                            <a href="{{ route('dashboard') }}"
                                class="rounded-xl border border-zinc-700 px-7 py-3.5 font-semibold text-zinc-300 transition hover:border-zinc-600 hover:bg-zinc-800 hover:text-white">
                                Clear
                            </a>

                        </div>

                    </div>

                </div>

            </form>


            {{-- Jobs --}}
            <div class="space-y-5">

                @forelse($jobs as $job)
                    <div
                        class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 shadow-lg transition duration-200 hover:-translate-y-0.5 hover:border-indigo-500/60 hover:shadow-indigo-500/5">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                            {{-- Job Information --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-start gap-4">

                                    <div>

                                        <h2
                                            class="text-2xl font-bold tracking-tight text-white transition group-hover:text-indigo-400">
                                            {{ $job->title }}
                                        </h2>

                                        <p class="mt-2 text-base font-medium text-zinc-400">
                                            {{ $job->company?->name ?? 'Company not specified' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Job Metadata --}}
                                <div class="mt-6 flex flex-wrap gap-x-7 gap-y-3 text-sm">

                                    <div class="flex items-center gap-2 text-zinc-400">
                                        <span class="text-base">📍</span>

                                        <span>
                                            {{ $job->location }}
                                        </span>
                                    </div>


                                    <div class="flex items-center gap-2 text-zinc-400">
                                        <span class="text-base">💼</span>

                                        <span>
                                            {{ $job->type }}
                                        </span>
                                    </div>


                                    @if ($job->salary)
                                        <div class="flex items-center gap-2 text-zinc-400">
                                            <span class="text-base">💰</span>

                                            <span>
                                                ${{ number_format($job->salary, 2) }}
                                            </span>
                                        </div>
                                    @endif

                                </div>

                            </div>


                            {{-- Job Type Badge --}}
                            @php

                                $badge = match ($job->type) {
                                    'Full-Time' => 'border-green-500/30 bg-green-500/10 text-green-400',

                                    'Contract' => 'border-orange-500/30 bg-orange-500/10 text-orange-400',

                                    'Remote' => 'border-blue-500/30 bg-blue-500/10 text-blue-400',

                                    'Hybrid' => 'border-purple-500/30 bg-purple-500/10 text-purple-400',

                                    default => 'border-zinc-700 bg-zinc-800 text-zinc-300',
                                };

                            @endphp


                            <span
                                class="{{ $badge }} self-start rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-wide">
                                {{ $job->type }}
                            </span>

                        </div>


                        {{-- Bottom Section --}}
                        <div
                            class="mt-7 flex flex-col gap-4 border-t border-zinc-800 pt-5 sm:flex-row sm:items-center sm:justify-between">

                            @if ($job->salary)
                                <p class="text-lg font-bold text-green-400">
                                    ${{ number_format($job->salary, 2) }}
                                </p>
                            @else
                                <p class="text-sm text-zinc-500">
                                    Salary not specified
                                </p>
                            @endif


                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 font-semibold text-white transition hover:bg-indigo-500">
                                View Details
                                <span class="ml-2 transition group-hover:translate-x-1">
                                    →
                                </span>
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-12 text-center">

                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-zinc-800">
                            🔎
                        </div>

                        <h3 class="text-xl font-semibold text-white">
                            No jobs found
                        </h3>

                        <p class="mt-2 text-zinc-500">
                            Try changing your search or filter.
                        </p>

                    </div>
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($jobs->hasPages())
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>
