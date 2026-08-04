<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            {{ $jobVacancy->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-5xl px-6">

            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                class="mb-6 inline-flex items-center text-indigo-400 hover:text-indigo-300">

                ← Back to Job Details

            </a>

            <form method="POST" action="{{ route('job-vacancies.process-application', $jobVacancy->id) }}"
                enctype="multipart/form-data">

                @csrf

                <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8">

                    {{-- Job Header --}}

                    <div class="flex flex-col gap-6 lg:flex-row lg:justify-between">

                        <div>

                            <h1 class="text-4xl font-bold text-white">

                                {{ $jobVacancy->title }}

                            </h1>

                            <p class="mt-2 text-lg text-gray-300">

                                {{ $jobVacancy->company?->name }}

                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-4">

                                <span class="text-gray-400">

                                    📍 {{ $jobVacancy->location }}

                                </span>

                                <span class="text-green-400 font-semibold">

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

                                <span class="{{ $badge }} rounded-lg px-4 py-2 text-sm text-white">

                                    {{ $jobVacancy->type }}

                                </span>

                            </div>

                        </div>

                    </div>

                    <hr class="my-8 border-zinc-800">

                    {{-- Resume Section --}}

                    <h2 class="text-2xl font-semibold text-white">

                        Choose Your Resume

                    </h2>

                    <p class="mt-2 text-gray-400">

                        Select one of your saved resumes or upload a new one.

                    </p>

                    {{-- Existing Resumes --}}

                    @if (auth()->user()->resumes->count())

                        <div class="mt-6 space-y-4">

                            @foreach (auth()->user()->resumes as $resume)
                                <label
                                    class="flex cursor-pointer items-center justify-between rounded-xl border border-zinc-700 bg-zinc-800 px-5 py-4 hover:border-indigo-500">

                                    <div>

                                        <input type="radio" name="resume_id" value="{{ $resume->id }}"
                                            class="mr-3">

                                        <span class="font-medium text-white">

                                            {{ $resume->title }}

                                        </span>

                                    </div>

                                    <span class="text-sm text-gray-400">

                                        Existing Resume

                                    </span>

                                </label>
                            @endforeach

                        </div>

                    @endif

                    {{-- Upload New Resume --}}

                    <div class="mt-8">

                        <label class="mb-3 block text-lg font-semibold text-white">

                            Upload New Resume

                        </label>

                        <input type="file" name="resume" accept=".pdf"
                            class="block w-full rounded-xl border-2 border-dashed border-zinc-700 bg-zinc-800 px-6 py-8 text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-5 file:py-2 file:text-white hover:border-indigo-500">

                        <p class="mt-3 text-sm text-gray-500">

                            PDF only • Maximum size 5 MB

                        </p>

                        @error('resume')
                            <p class="mt-2 text-red-500">

                                {{ $message }}

                            </p>
                        @enderror

                    </div>

                    {{-- Submit --}}

                    <div class="mt-10">

                        <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 py-4 text-lg font-semibold text-white transition hover:scale-[1.01]">

                            Apply Now

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
