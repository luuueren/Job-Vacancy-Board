<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $jobVacancy->title }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $jobVacancy->company?->name ?? 'No Company' }}
                </p>

            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">

                <a href="{{ route('job-vacancy.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-100">

                    ← Back

                </a>

                <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}"
                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700">

                    ✏️ Edit

                </a>

                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        onclick="return confirm('Are you sure you want to archive this job vacancy?')"
                        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700">

                        🗃 Archive

                    </button>

                </form>

            </div>

        </div>

    </x-slot>


    <div class="p-6">

        <div class="mx-auto max-w-6xl rounded-xl border border-gray-200 bg-white shadow">

            <!-- Card Header -->
            <div class="flex items-center justify-between border-b bg-gray-50 px-6 py-5">

                <div>

                    <h3 class="text-xl font-semibold text-gray-800">
                        Job Vacancy Information
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Complete information about this job vacancy.
                    </p>

                </div>

                <span
                    class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-1 text-sm font-semibold text-indigo-700">

                    {{ $jobVacancy->type }}

                </span>

            </div>

            <!-- Details -->
            <div class="divide-y divide-gray-100">

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Job Title
                    </span>

                    <span class="col-span-2 font-semibold text-gray-900">
                        {{ $jobVacancy->title }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Company
                    </span>

                    <span class="col-span-2 font-semibold text-gray-900">
                        {{ $jobVacancy->company?->name ?? 'No Company' }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Category
                    </span>

                    <span
                        class="inline-flex w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                        {{ $jobVacancy->JobCategory?->name ?? 'No Category' }}

                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Location
                    </span>

                    <span class="col-span-2 text-gray-700">
                        {{ $jobVacancy->location }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Salary
                    </span>

                    <span class="col-span-2 text-lg font-bold text-green-600">
                        ${{ number_format($jobVacancy->salary, 2) }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Description
                    </span>

                    <div class="col-span-2 whitespace-pre-line leading-7 text-gray-700">

                        {{ $jobVacancy->description }}

                    </div>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Created At
                    </span>

                    <span class="col-span-2">
                        {{ $jobVacancy->created_at->format('M d, Y • H:i') }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Last Updated
                    </span>

                    <span class="col-span-2">
                        {{ $jobVacancy->updated_at->diffForHumans() }}
                    </span>

                </div>

            </div>

        </div>

        <!-- Applications --><!-- ========================= -->
        <!-- Applications -->
        <!-- ========================= -->

        <div class="mt-8">

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <h3 class="text-xl font-semibold text-gray-800">
                        Job Applications
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Applications submitted for this vacancy.
                    </p>

                </div>

                <span
                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">

                    {{ $jobVacancy->jobApplications->count() }}
                    {{ Str::plural('Application', $jobVacancy->jobApplications->count()) }}

                </span>

            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Applicant
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Resume
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                AI Score
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Applied
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse($jobVacancy->jobApplications as $application)
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-gray-900">
                                        {{ $application->user->name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $application->user->email }}
                                    </div>

                                </td>

                                <td class="px-6 py-4">

                                    @if ($application->resume)
                                        <a href="#"
                                            class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline">

                                            View Resume

                                        </a>
                                    @else
                                        <span class="italic text-gray-400">
                                            No Resume
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    @php

                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'reviewing' => 'bg-blue-100 text-blue-800',
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];

                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-700' }}">

                                        {{ ucfirst($application->status) }}

                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    @if (!is_null($application->aiGeneratedScore))
                                        <span class="font-bold text-indigo-700">
                                            {{ $application->aiGeneratedScore }}/100
                                        </span>
                                    @else
                                        <span class="italic text-gray-400">
                                            N/A
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">

                                    {{ $application->created_at->diffForHumans() }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div class="mb-3 text-5xl">
                                            📄
                                        </div>

                                        <h4 class="text-lg font-semibold text-gray-700">
                                            No Applications Yet
                                        </h4>

                                        <p class="mt-1 text-sm text-gray-500">
                                            This job vacancy has not received any applications.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
