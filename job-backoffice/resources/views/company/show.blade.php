<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ $company->name }}
            </h2>

            <a href="{{ route('company.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                ← Back to Companies
            </a>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Company Card --}}
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b bg-gray-50">

                <div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Company Information
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Basic information about this company.
                    </p>
                </div>

                <span
                    class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                    {{ $company->industry }}
                </span>

            </div>

            {{-- Body --}}
            <div class="divide-y divide-gray-100">

                <div class="grid grid-cols-3 gap-6 px-6 py-5">
                    <span class="font-medium text-gray-500">
                        Company Name
                    </span>

                    <span class="col-span-2 font-semibold text-gray-900">
                        {{ $company->name }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Website
                    </span>

                    <div class="col-span-2">

                        @if ($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                                class="text-blue-600 hover:text-blue-800 hover:underline break-all">

                                {{ $company->website }}

                            </a>
                        @else
                            <span class="italic text-gray-400">
                                No website available
                            </span>
                        @endif

                    </div>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Address
                    </span>

                    <span class="col-span-2 text-gray-700">
                        {{ $company->address }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Created At
                    </span>

                    <span class="col-span-2 text-gray-700">
                        {{ $company->created_at->format('M d, Y • H:i') }}
                    </span>

                </div>

                <div class="grid grid-cols-3 gap-6 px-6 py-5">

                    <span class="font-medium text-gray-500">
                        Last Updated
                    </span>

                    <span class="col-span-2 text-gray-700">
                        {{ $company->updated_at->diffForHumans() }}
                    </span>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex flex-wrap justify-end gap-3 px-6 py-5 border-t border-gray-200 bg-gray-50">

                <form action="{{ route('company.destroy', $company->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Are you sure you want to archive this company?')"
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition">

                        🗃 Archive

                    </button>

                </form>

                <a href="{{ route('company.edit', $company->id) }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">

                    ✏ Edit

                </a>

                <a href="{{ route('company.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition">

                    ← Back

                </a>

            </div>

        </div>

        {{-- Tabs --}}
        <div x-data="{ tab: 'jobs' }" class="max-w-6xl mx-auto mt-8">

            <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

                {{-- Navigation --}}
                <div class="flex border-b border-gray-200">

                    <button @click="tab='jobs'"
                        :class="tab === 'jobs' ?
                            'border-indigo-600 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-6 py-4 border-b-2 font-medium transition">

                        Jobs
                        <span class="ml-2 rounded-full bg-gray-100 px-2 py-0.5 text-xs">
                            {{ $company->jobVacancies->count() }}
                        </span>

                    </button>

                    <button @click="tab='applications'"
                        :class="tab === 'applications' ?
                            'border-indigo-600 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-6 py-4 border-b-2 font-medium transition">

                        Applications
                        <span class="ml-2 rounded-full bg-gray-100 px-2 py-0.5 text-xs">
                            {{ $applications->count() }}
                        </span>

                    </button>

                </div>

                {{-- Jobs Tab --}}
                <div x-show="tab==='jobs'" x-cloak>

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Job Title
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Type
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Location
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white"></tbody>
                            @forelse ($company->jobVacancies as $job)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $job->title }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">

                                            {{ $job->type }}

                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $job->location }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <a href="{{ route('job-vacancy.show', $job->id) }}"
                                            class="text-indigo-600 hover:text-indigo-800 font-medium">

                                            View →

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">

                                        No job vacancies found for this company.

                                    </td>

                                </tr>
                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- Applications Tab --}}
                <div x-show="tab==='applications'" x-cloak>

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Applicant
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Email
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Job
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        AI Score
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @forelse($applications as $application)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-6 py-4 font-medium text-gray-900">

                                            {{ $application->user->name }}

                                        </td>

                                        <td class="px-6 py-4 text-gray-700">

                                            {{ $application->user->email }}

                                        </td>

                                        <td class="px-6 py-4 text-gray-700">

                                            {{ $application->jobVacancy->title }}

                                        </td>

                                        <td class="px-6 py-4">

                                            @php
                                                $score = $application->aiGeneratedScore;
                                            @endphp

                                            @if ($score >= 8)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                                    {{ $score }}

                                                </span>
                                            @elseif ($score >= 5)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                                    {{ $score }}

                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                                    {{ $score }}

                                                </span>
                                            @endif

                                        </td>

                                        <td class="px-6 py-4">

                                            <a href="{{ route('application.show', $application->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium">

                                                View →

                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">

                                            No applications have been submitted yet.

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
