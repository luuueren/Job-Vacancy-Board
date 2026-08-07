<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="text-2xl font-bold text-white">
                {{ __('My Job Applications') }}
            </h2>

            <p class="mt-1 text-sm text-zinc-400">
                Track your job applications and AI matching results.
            </p>
        </div>

    </x-slot>

    <div class="min-h-screen bg-zinc-950 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-5 py-4 text-green-400">
                    <div class="flex items-center gap-3">
                        <span class="text-lg">✓</span>

                        <p class="font-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Info Message --}}
            @if (session('info'))
                <div class="mb-6 rounded-xl border border-blue-500/30 bg-blue-500/10 px-5 py-4 text-blue-400">
                    <div class="flex items-center gap-3">
                        <span class="text-lg">ℹ</span>

                        <p class="font-medium">
                            {{ session('info') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Empty State --}}
            @if ($jobApplications->isEmpty())

                <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-12 text-center shadow-xl">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-zinc-800">
                        <span class="text-2xl">📄</span>
                    </div>

                    <h3 class="mt-6 text-2xl font-semibold text-white">
                        No applications yet
                    </h3>

                    <p class="mx-auto mt-3 max-w-md text-zinc-400">
                        You haven't applied for any jobs yet.
                        Browse available opportunities and submit your first application.
                    </p>

                    <a href="{{ route('dashboard') }}"
                        class="mt-7 inline-flex items-center rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-zinc-950">
                        Browse Jobs
                    </a>

                </div>
            @else
                {{-- Applications --}}
                <div class="space-y-6">

                    @foreach ($jobApplications as $application)
                        @php
                            $score = (int) ($application->aiGeneratedScore ?? 0);

                            $scoreColor = match (true) {
                                $score >= 80 => 'bg-green-500',
                                $score >= 60 => 'bg-yellow-500',
                                $score > 0 => 'bg-red-500',
                                default => 'bg-zinc-600',
                            };

                            $scoreTextColor = match (true) {
                                $score >= 80 => 'text-green-400',
                                $score >= 60 => 'text-yellow-400',
                                $score > 0 => 'text-red-400',
                                default => 'text-zinc-400',
                            };

                            $statusClasses = match ($application->status) {
                                'accepted' => 'border-green-500/30 bg-green-500/10 text-green-400',
                                'rejected' => 'border-red-500/30 bg-red-500/10 text-red-400',
                                default => 'border-yellow-500/30 bg-yellow-500/10 text-yellow-400',
                            };
                        @endphp

                        <div class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 shadow-xl">

                            {{-- Application Header --}}
                            <div class="p-6 sm:p-8">

                                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                                    <div>

                                        <h3 class="text-2xl font-bold text-white">
                                            {{ $application->jobVacancy->title }}
                                        </h3>

                                        @if ($application->jobVacancy->company)
                                            <p class="mt-1 text-lg text-zinc-400">
                                                {{ $application->jobVacancy->company->name }}
                                            </p>
                                        @endif

                                        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-3 text-sm text-zinc-400">

                                            <span class="flex items-center gap-2">
                                                <span>📍</span>
                                                {{ $application->jobVacancy->location }}
                                            </span>

                                            <span class="flex items-center gap-2">
                                                <span>💼</span>
                                                {{ ucfirst($application->jobVacancy->type) }}
                                            </span>

                                            <span class="flex items-center gap-2">
                                                <span>🕒</span>
                                                Applied {{ $application->created_at->diffForHumans() }}
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Status --}}
                                    <span
                                        class="inline-flex w-fit items-center rounded-full border px-4 py-2 text-sm font-semibold {{ $statusClasses }}">

                                        {{ ucfirst($application->status) }}

                                    </span>

                                </div>

                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-zinc-800"></div>

                            {{-- AI Results --}}
                            <div class="space-y-7 p-6 sm:p-8">

                                {{-- AI Match Score --}}
                                <div>

                                    <div class="mb-3 flex items-center justify-between">

                                        <div>
                                            <h4 class="text-lg font-semibold text-white">
                                                AI Match Score
                                            </h4>

                                            <p class="mt-1 text-sm text-zinc-500">
                                                How well your resume matches this position.
                                            </p>
                                        </div>

                                        <span class="text-2xl font-bold {{ $scoreTextColor }}">
                                            {{ $score }}%
                                        </span>

                                    </div>

                                    {{-- Progress Bar --}}
                                    <div class="h-3 w-full overflow-hidden rounded-full bg-zinc-800">

                                        <div class="{{ $scoreColor }} h-full rounded-full transition-all duration-500"
                                            style="width: {{ min(100, max(0, $score)) }}%">
                                        </div>

                                    </div>

                                </div>

                                {{-- AI Feedback --}}
                                <div>

                                    <h4 class="text-lg font-semibold text-white">
                                        AI Feedback
                                    </h4>

                                    <div class="mt-3 rounded-xl border border-zinc-800 bg-zinc-950 p-5">

                                        @if ($application->aiGeneratedFeedback)
                                            <p class="leading-7 text-zinc-300">
                                                {{ $application->aiGeneratedFeedback }}
                                            </p>
                                        @else
                                            <div class="flex items-center gap-3 text-zinc-500">
                                                <span>⏳</span>

                                                <p>
                                                    AI feedback is not available yet.
                                                </p>
                                            </div>
                                        @endif

                                    </div>

                                </div>

                                {{-- Resume --}}
                                @if ($application->resume)
                                    <div
                                        class="flex flex-col gap-4 rounded-xl border border-zinc-800 bg-zinc-950 p-5 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <h4 class="font-semibold text-white">
                                                Submitted Resume
                                            </h4>

                                            <p class="mt-1 text-sm text-zinc-500">
                                                {{ $application->resume->fileName }}
                                            </p>
                                        </div>

                                        @if ($application->resume->fileUri)
                                            <a href="{{ Storage::disk('s3')->temporaryUrl($application->resume->fileUri, now()->addMinutes(10)) }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="inline-flex w-fit items-center rounded-lg border border-zinc-700 px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-indigo-500 hover:bg-indigo-500/10 hover:text-indigo-400">
                                                View Resume
                                            </a>
                                        @endif

                                    </div>
                                @endif

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
