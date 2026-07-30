<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Application Status') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-6 py-8">

        <form action="{{ route('application.update', $jobApplication->id) }}" method="POST">

            @csrf
            @method('PATCH')

            {{-- ========================= --}}
            {{-- Applicant Information --}}
            {{-- ========================= --}}

            <div class="overflow-hidden rounded-xl bg-white shadow mb-8">

                <div class="border-b bg-gray-50 px-6 py-4">

                    <h3 class="text-lg font-bold text-gray-800">
                        Applicant Information
                    </h3>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            Applicant Name
                        </label>

                        <input type="text" value="{{ $jobApplication->user->name }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            Applicant Email
                        </label>

                        <input type="text" value="{{ $jobApplication->user->email }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                </div>

            </div>

            {{-- ========================= --}}
            {{-- Job Information --}}
            {{-- ========================= --}}

            <div class="overflow-hidden rounded-xl bg-white shadow mb-8">

                <div class="border-b bg-gray-50 px-6 py-4">

                    <h3 class="text-lg font-bold text-gray-800">
                        Job Information
                    </h3>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            Job Title
                        </label>

                        <input type="text" value="{{ $jobApplication->jobVacancy->title }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            Company
                        </label>

                        <input type="text" value="{{ $jobApplication->jobVacancy->company->name }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                </div>

            </div>

            {{-- ========================= --}}
            {{-- Resume Information --}}
            {{-- ========================= --}}

            <div class="overflow-hidden rounded-xl bg-white shadow mb-8">

                <div class="border-b bg-gray-50 px-6 py-4">

                    <h3 class="text-lg font-bold text-gray-800">
                        Resume Summary
                    </h3>

                </div>

                <div class="p-6">

                    <textarea rows="8" readonly class="w-full rounded-lg border-gray-300 bg-gray-100 resize-none">{{ $jobApplication->resume->summary }}</textarea>

                </div>

            </div>

            {{-- ========================= --}}
            {{-- AI Evaluation --}}
            {{-- ========================= --}}

            <div class="overflow-hidden rounded-xl bg-white shadow mb-8">

                <div class="border-b bg-gray-50 px-6 py-4">

                    <h3 class="text-lg font-bold text-gray-800">
                        AI Evaluation
                    </h3>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            AI Score
                        </label>

                        <input type="text" readonly value="{{ $jobApplication->aiGeneratedScore }}"
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-gray-500 mb-2">
                            Current Status
                        </label>

                        <input type="text" readonly value="{{ ucfirst($jobApplication->status) }}"
                            class="w-full rounded-lg border-gray-300 bg-gray-100">

                    </div>

                </div>

                <div class="px-6 pb-6">

                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        AI Feedback
                    </label>

                    <textarea rows="6" readonly class="w-full rounded-lg border-gray-300 bg-gray-100 resize-none">{{ $jobApplication->aiGeneratedFeedback }}</textarea>

                </div>

            </div>

            {{-- ========================= --}}
            {{-- Update Status --}}
            {{-- ========================= --}}

            <div class="overflow-hidden rounded-xl bg-white shadow">

                <div class="border-b bg-indigo-50 px-6 py-4">

                    <h3 class="text-lg font-bold text-indigo-700">
                        Update Application Status
                    </h3>

                </div>

                <div class="p-6">

                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">

                        Status

                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="pending"
                            {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="accepted"
                            {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>
                            Accepted
                        </option>

                        <option value="rejected"
                            {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- ========================= --}}
            {{-- Actions --}}
            {{-- ========================= --}}

            <div class="flex items-center justify-end gap-3 mt-8">

                <a href="{{ route('application.show', $jobApplication->id) }}"
                    class="inline-flex items-center px-5 py-2.5
                           rounded-lg border border-gray-300
                           bg-white text-gray-700 font-medium
                           hover:bg-gray-100 transition">

                    Cancel

                </a>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5
                           rounded-lg bg-indigo-600
                           text-white font-medium
                           hover:bg-indigo-700
                           transition">

                    💾 Update Status

                </button>

            </div>

        </form>

    </div>

</x-app-layout>
