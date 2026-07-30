<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Job Application Details
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Review applicant information, resume details and AI evaluation.
                </p>
            </div>

            <a href="{{ route('application.index') }}"
                class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">

                ← Back to Applications

            </a>

        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 p-6">

        {{-- ========================= --}}
        {{-- Application Information --}}
        {{-- ========================= --}}

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b bg-gray-50 px-6 py-4">

                <h3 class="text-lg font-bold text-gray-800">
                    Application Information
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">

                {{-- Status --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Status
                    </label>

                    @php
                        $statusClasses = match ($jobApplication->status) {
                            'accepted' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp

                    <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses }}">
                        {{ ucfirst($jobApplication->status) }}
                    </span>

                </div>

                {{-- AI Score --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        AI Score
                    </label>

                    <div class="flex items-center gap-3">

                        <div class="h-3 w-full rounded-full bg-gray-200">

                            <div class="h-3 rounded-full bg-indigo-600"
                                style="width: {{ min($jobApplication->aiGeneratedScore, 100) }}%">
                            </div>

                        </div>

                        <span class="font-bold text-indigo-600">
                            {{ $jobApplication->aiGeneratedScore }}%
                        </span>

                    </div>

                </div>

                {{-- Created --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Applied At
                    </label>

                    <p class="text-gray-800">
                        {{ $jobApplication->created_at->format('d M Y • H:i') }}
                    </p>

                </div>

                {{-- Updated --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Last Updated
                    </label>

                    <p class="text-gray-800">
                        {{ $jobApplication->updated_at->format('d M Y • H:i') }}
                    </p>

                </div>

            </div>

        </div>

        {{-- ========================= --}}
        {{-- Applicant Information --}}
        {{-- ========================= --}}

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b bg-gray-50 px-6 py-4">

                <h3 class="text-lg font-bold text-gray-800">
                    Applicant Information
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Full Name
                    </label>

                    <p class="font-semibold text-gray-900">
                        {{ $jobApplication->user->name }}
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Email
                    </label>

                    <p class="text-gray-700">
                        {{ $jobApplication->user->email }}
                    </p>

                </div>

            </div>

        </div> {{-- ========================= --}}
        {{-- Job Information --}}
        {{-- ========================= --}}

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b bg-gray-50 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">
                    Job Information
                </h3>
            </div>

            <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Job Title
                    </label>

                    <p class="font-semibold text-indigo-700">
                        {{ $jobApplication->jobVacancy->title }}
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Company
                    </label>

                    <p class="text-gray-800">
                        {{ $jobApplication->jobVacancy->company->name }}
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Job Type
                    </label>

                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">
                        {{ $jobApplication->jobVacancy->type }}
                    </span>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Salary
                    </label>

                    <p class="font-semibold text-green-600">
                        ${{ number_format($jobApplication->jobVacancy->salary, 2) }}
                    </p>

                </div>

            </div>

        </div>

        {{-- ========================= --}}
        {{-- Resume Information --}}
        {{-- ========================= --}}

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b bg-gray-50 px-6 py-4">

                <h3 class="text-lg font-bold text-gray-800">
                    Resume Information
                </h3>

            </div>

            <div class="space-y-6 p-6">

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Summary
                    </label>

                    <div class="rounded-lg bg-gray-50 p-4 text-gray-700">
                        {{ $jobApplication->resume->summary }}
                    </div>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Skills
                    </label>

                    <div class="rounded-lg bg-gray-50 p-4 text-gray-700">
                        {{ $jobApplication->resume->skills }}
                    </div>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Experience
                    </label>

                    <div class="rounded-lg bg-gray-50 p-4 text-gray-700">
                        {{ $jobApplication->resume->experience }}
                    </div>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Education
                    </label>

                    <div class="rounded-lg bg-gray-50 p-4 text-gray-700">
                        {{ $jobApplication->resume->education }}
                    </div>

                </div>

            </div>

        </div>

        {{-- ========================= --}}
        {{-- AI Feedback --}}
        {{-- ========================= --}}

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b bg-gray-50 px-6 py-4">

                <h3 class="text-lg font-bold text-gray-800">
                    AI Evaluation
                </h3>

            </div>

            <div class="p-6">

                @if ($jobApplication->aiGeneratedFeedback)
                    <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-5">

                        <p class="leading-7 text-gray-700">
                            {{ $jobApplication->aiGeneratedFeedback }}
                        </p>

                    </div>
                @else
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">

                        <p class="italic text-gray-500">
                            No AI feedback available.
                        </p>

                    </div>
                @endif

            </div>

        </div>

        {{-- ========================= --}}
        {{-- Actions --}}
        {{-- ========================= --}}

        <div class="flex items-center justify-end gap-3">

            <a href="{{ route('application.index') }}"
                class="rounded-lg bg-gray-200 px-5 py-2.5 font-semibold text-gray-700 transition hover:bg-gray-300">

                Cancel

            </a>

            <a href="{{ route('application.edit', $jobApplication->id) }}"
                class="rounded-lg bg-indigo-600 px-5 py-2.5 font-semibold text-white transition hover:bg-indigo-700">

                ✏️ Edit

            </a>

            <form action="{{ route('application.destroy', $jobApplication->id) }}" method="POST">

                @csrf
                @method('DELETE')

                <button type="submit" onclick="return confirm('Are you sure you want to archive this application?')"
                    class="rounded-lg bg-red-600 px-5 py-2.5 font-semibold text-white transition hover:bg-red-700">

                    🗃 Archive

                </button>

            </form>

        </div>

    </div>

</x-app-layout>
