<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Welcome --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-gray-900">
                    Dashboard Analytics
                </h1>

                <p class="mt-2 text-gray-500">
                    Welcome back, Admin 👋
                </p>

            </div>

            {{-- Statistics --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Active Users --}}
                <div class="rounded-xl bg-white p-6 shadow">

                    <p class="text-sm font-medium text-gray-500">
                        Active Users
                    </p>

                    <h2 class="mt-3 text-4xl font-bold text-indigo-600">
                        {{ $analytics['activeUsers'] }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        Last 30 Days
                    </p>

                </div>

                {{-- Active Jobs --}}
                <div class="rounded-xl bg-white p-6 shadow">

                    <p class="text-sm font-medium text-gray-500">
                        Active Job Vacancies
                    </p>

                    <h2 class="mt-3 text-4xl font-bold text-indigo-600">
                        {{ $analytics['activeJobVacancies'] }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        Currently Active
                    </p>

                </div>

                {{-- Applications --}}
                <div class="rounded-xl bg-white p-6 shadow">

                    <p class="text-sm font-medium text-gray-500">
                        Total Applications
                    </p>

                    <h2 class="mt-3 text-4xl font-bold text-indigo-600">
                        {{ $analytics['totalApplications'] }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        All Time
                    </p>

                </div>

            </div>

            {{-- Most Applied Jobs --}}
            <div class="mt-10 rounded-xl bg-white shadow">

                <div class="border-b px-6 py-5">

                    <h2 class="text-xl font-bold text-gray-800">

                        Most Applied Jobs

                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-gray-50">

                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Job Title
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Company
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Applications
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse ($mostAppliedJobs as $job)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $job->title }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $job->company?->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            {{ $job->totalCount }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">

                                        No job vacancies found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Top Converting Jobs --}}
            <div class="mt-10 rounded-xl bg-white shadow">

                <div class="border-b px-6 py-5">

                    <h2 class="text-xl font-bold text-gray-800">

                        Top Converting Job Posts

                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-gray-50">

                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Job Title
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Views
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Applications
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Conversion Rate
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse ($conversionRates as $job)
                                <tr class="transition hover:bg-gray-50">

                                    {{-- Job Title --}}
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $job->title }}
                                    </td>

                                    {{-- Views --}}
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ number_format($job->viewCount) }}
                                    </td>

                                    {{-- Applications --}}
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $job->totalCount }}
                                    </td>

                                    {{-- Conversion Rate --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            {{ $job->conversionRate }}%
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">

                                        No job vacancies found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>
