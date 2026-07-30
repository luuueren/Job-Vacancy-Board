<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Add Job Vacancy
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Create a new job vacancy.
                </p>
            </div>

            <a href="{{ route('job-vacancy.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg
                       text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                ← Back to Job Vacancies
            </a>
        </div>
    </x-slot>


    <div class="py-8">

        <div class="max-w-5xl mx-auto px-6">

            <form action="{{ route('job-vacancy.store') }}" method="POST">

                @csrf

                <!-- ========================= -->
                <!-- JobVacancy Information Card -->
                <!-- ========================= -->

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">

                    <div class="px-6 py-5 bg-gray-50 border-b">

                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            Job Details
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Fill in the basic information about the job vacancy.
                        </p>

                    </div>

                    <div class="p-6">

                        <!--  Title -->
                        <div class="mb-6">

                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Job Title
                            </label>

                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                placeholder="e.g. Software Engineer"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('title')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror


                        </div>

                        <!-- Location -->
                        <div class="mb-6">

                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                                Location
                            </label>

                            <input type="text" id="location" name="location" value="{{ old('location') }}"
                                placeholder="e.g. 123 Main St, City, State 12345"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('location')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Salary -->
                        <div class="mb-6">
                            <label for="salary" class="block text-sm font-semibold text-gray-700 mb-2">
                                Salary
                            </label>

                            <input type="number" step="0.01" min="0" id="salary" name="salary"
                                value="{{ old('salary') }}" placeholder="e.g. 60000"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('salary')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Type of Job
                            </label>
                            <select name="type" id="type"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Job Type</option>
                                <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time
                                </option>
                                <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract
                                </option>
                                <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : '' }}>Remote
                                </option>
                                <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid
                                </option>

                            </select>

                            @error('type')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>



                        <!-- Website -->
                        {{-- <div>

                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">
                                Website
                                <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>

                            <input type="url" id="website" name="website" value="{{ old('website') }}"
                                placeholder="https://example.com"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('website')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div> --}}

                    </div>

                </div>

                {{-- Company Select Dropdown  --}}
                <div class="mb-6">

                    <label for="companyId" class="block text-sm font-semibold text-gray-700 mb-2">
                        Company
                    </label>

                    <select name="companyId" id="companyId"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">Select a company</option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('companyId') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('companyId')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Job Category Select Dropdown --}}
                <div class="mb-6">

                    <label for="jobCategoryId" class="block text-sm font-semibold text-gray-700 mb-2">
                        Job Category
                    </label>

                    <select name="jobCategoryId" id="jobCategoryId"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">Select a job category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('jobCategoryId') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('jobCategoryId')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Job Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Job Description
                    </label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full rounded-lg border-gray-300 shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter job description">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between mt-8">

                    <a href="{{ route('job-vacancy.index') }}"
                        class="inline-flex items-center px-5 py-2.5
                               rounded-lg border border-gray-300
                               bg-white text-gray-700 text-sm font-medium
                               hover:bg-gray-100 transition">

                        Cancel

                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2
                               px-6 py-2.5 rounded-lg
                               bg-indigo-600 text-white
                               text-sm font-semibold
                               hover:bg-indigo-700
                               transition
                               shadow">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                        </svg>

                        Add Job Vacancy

                    </button>

                </div>

            </form>

        </div>

    </div>



</x-app-layout>
