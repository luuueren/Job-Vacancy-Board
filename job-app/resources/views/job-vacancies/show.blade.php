<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Back Button --}}

            <a href="{{ route('dashboard') }}"
                class="mb-6 inline-flex items-center text-indigo-400 transition hover:text-indigo-300">

                ← Back to Jobs

            </a>

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8">

                {{-- Header --}}

                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                    <div>

                        <h1 class="text-4xl font-bold text-white">

                            {{ $jobVacancy->title }}

                        </h1>

                        <p class="mt-2 text-lg text-gray-300">

                            {{ $jobVacancy->company?->name }}

                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-4 text-gray-400">

                            <span>

                                📍 {{ $jobVacancy->location }}

                            </span>

                            <span>

                                •

                            </span>

                            <span class="font-semibold text-green-400">

                                ${{ number_format($jobVacancy->salary, 2) }}

                            </span>

                            @php

                                $badge = match ($jobVacancy->type) {
                                    'Full-Time' => 'bg-green-600',

                                    'Contract' => 'bg-orange-600',

                                    'Remote' => 'bg-blue-600',

                                    'Hybrid' => 'bg-purple-600',

                                    default => 'bg-gray-600',
                                };

                            @endphp

                            <span class="{{ $badge }} rounded-lg px-4 py-2 text-sm font-semibold text-white">

                                {{ $jobVacancy->type }}

                            </span>

                        </div>

                    </div>

                    <div>

                        <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}"
                            class="rounded-xl bg-gradient-to-r from-indigo-600 to-pink-500 px-8 py-3 font-semibold text-white transition hover:scale-105">

                            Apply Now

                        </a>

                    </div>

                </div>

                <hr class="my-8 border-zinc-800">

                {{-- Content --}}

                <div class="grid gap-10 lg:grid-cols-3">

                    {{-- Description --}}

                    <div class="lg:col-span-2">

                        <h3 class="mb-5 text-2xl font-semibold text-white">

                            Job Description

                        </h3>

                        <div class="leading-8 text-gray-300 whitespace-pre-line">

                            {{ $jobVacancy->description }}

                        </div>

                    </div>

                    {{-- Overview --}}

                    <div>

                        <div class="rounded-xl bg-zinc-800/60 p-6">

                            <h3 class="mb-6 text-xl font-semibold text-white">

                                Job Overview

                            </h3>

                            <div class="space-y-6">

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Published

                                    </p>

                                    <p class="mt-1 text-white">

                                        {{ $jobVacancy->created_at->format('M d, Y') }}

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Company

                                    </p>

                                    <p class="mt-1 text-white">

                                        {{ $jobVacancy->company?->name }}

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Category

                                    </p>

                                    <p class="mt-1 text-white">

                                        {{ $jobVacancy->jobCategory?->name }}

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Location

                                    </p>

                                    <p class="mt-1 text-white">

                                        {{ $jobVacancy->location }}

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Salary

                                    </p>

                                    <p class="mt-1 font-semibold text-green-400">

                                        ${{ number_format($jobVacancy->salary, 2) }}

                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Employment Type

                                    </p>

                                    <p class="mt-1 text-white">

                                        {{ $jobVacancy->type }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
