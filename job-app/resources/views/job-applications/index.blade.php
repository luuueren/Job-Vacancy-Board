<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('My Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-6">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-500/30 bg-green-500/10 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Empty State --}}
            @if ($jobApplications->isEmpty())

                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800">
                        No applications yet
                    </h3>

                    <p class="mt-3 text-gray-500">
                        You haven't applied for any jobs yet.
                    </p>

                    <a href="{{ route('dashboard') }}"
                        class="mt-6 inline-flex rounded-lg bg-indigo-600 px-6 py-3 font-medium text-white transition hover:bg-indigo-700">
                        Browse Jobs
                    </a>

                </div>
            @else
                <div class="space-y-6">

                    @foreach ($jobApplications as $application)
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                            <div class="flex items-start justify-between">

                                <div>

                                    <h3 class="text-2xl font-bold text-gray-900">
                                        {{ $application->jobVacancy->title }}
                                    </h3>

                                    <p class="mt-1 text-gray-600">
                                        {{ $application->jobVacancy->company->name }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-500">

                                        <span>
                                            📍 {{ $application->jobVacancy->location }}
                                        </span>

                                        <span>
                                            💼 {{ ucfirst($application->jobVacancy->type) }}
                                        </span>

                                        <span>
                                            🕒 Applied {{ $application->created_at->diffForHumans() }}
                                        </span>

                                    </div>

                                </div>

                                <span
                                    class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800">

                                    {{ ucfirst($application->status) }}

                                </span>

                            </div>

                            <hr class="my-6">

                            <div>

                                <div class="mb-2 flex items-center justify-between">

                                    <span class="font-semibold text-gray-700">
                                        AI Match Score
                                    </span>

                                    <span class="text-lg font-bold">

                                        {{ $application->aiGeneratedScore }}%

                                    </span>

                                </div>

                                @php
                                    $score = $application->aiGeneratedScore;

                                    $color = match (true) {
                                        $score >= 90 => 'bg-green-500',
                                        $score >= 70 => 'bg-yellow-500',
                                        default => 'bg-red-500',
                                    };
                                @endphp

                                <div class="h-3 w-full rounded-full bg-gray-200">

                                    <div class="{{ $color }} h-3 rounded-full"
                                        style="width: {{ $score }}%">
                                    </div>

                                </div>

                            </div>

                            <div class="mt-6">

                                <h4 class="mb-2 font-semibold text-gray-800">
                                    AI Feedback
                                </h4>

                                <div class="rounded-lg bg-gray-50 p-4 text-gray-700">

                                    {{ $application->aiGeneratedFeedback ?: 'No AI feedback available yet.' }}

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>
    </div>
</x-app-layout>
