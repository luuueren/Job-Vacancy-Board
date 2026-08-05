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
                enctype="multipart/form-data" onsubmit="document.getElementById('submit-btn').disabled = true;">

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

                    <div class="mt-8">
                        <div class="space-y-4">
                            {{-- Existing Resumes --}}
                            @foreach ($resumes as $resume)
                                <label
                                    class="flex cursor-pointer items-center justify-between rounded-xl border border-zinc-700 bg-zinc-800 px-5 py-4 transition hover:border-indigo-500">
                                    <div class="flex items-center">
                                        <input type="radio" name="resume_option" value="existing"
                                            class="resume-option mr-4 h-5 w-5 text-indigo-600"
                                            data-resume-id="{{ $resume->id }}"
                                            {{ old('resume_id') === $resume->id ? 'checked' : '' }}
                                            onclick="selectExistingResume('{{ $resume->id }}')">

                                        <div>
                                            <p class="font-medium text-white">
                                                {{ $resume->fileName }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-400">
                                                Uploaded {{ $resume->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>


                                    <a href="{{ $resume->viewUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="text-indigo-400 hover:text-indigo-300">
                                        View PDF
                                    </a>
                                </label>
                            @endforeach

                            {{-- Upload New Resume --}}
                            <label
                                class="block rounded-xl border-2 border-dashed border-zinc-700 bg-zinc-800 p-6 transition hover:border-indigo-500">
                                <div class="mb-4 flex items-center">
                                    <input id="new_resume_radio" type="radio" name="resume_option" value="new"
                                        class="resume-option mr-4 h-5 w-5 text-indigo-600" onclick="selectNewResume()">

                                    <span class="text-lg font-semibold text-white">
                                        Upload New Resume
                                    </span>
                                </div>

                                <input id="resume_file" type="file" name="resume_file" accept="application/pdf"
                                    class="block w-full text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-5 file:py-2 file:text-white"
                                    onchange="handleFileSelect()">

                                <p class="mt-3 text-sm text-gray-400">
                                    PDF only • Maximum size 5 MB
                                </p>
                            </label>

                            {{-- Hidden resume id --}}
                            <input type="hidden" id="resume_id" name="resume_id" value="{{ old('resume_id') }}">
                        </div>

                        {{-- Reset Button --}}
                        <div class="mt-6 flex items-center justify-between">
                            {{--
                                تم تغيير type من "reset" إلى "button":
                                type="reset" الأصلي كان يُعيد ضبط الحقل المخفي resume_id
                                إلى قيمته الافتراضية (old('resume_id')) بعد أن تقوم دالة
                                resetForm() بمسحه، مما قد يُعيد قيمة قديمة خاطئة.
                            --}}
                            <button type="button"
                                class="rounded-lg bg-zinc-700 px-6 py-2 text-white transition hover:bg-zinc-600"
                                onclick="resetForm()">
                                🔄 Reset Selection
                            </button>

                            <span id="file-status" class="text-sm text-gray-400">
                                No file selected
                            </span>
                        </div>

                        {{-- Error Messages --}}
                        @error('resume_option')
                            <div class="mt-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3">
                                <p class="text-red-400">{{ $message }}</p>
                            </div>
                        @enderror

                        @error('resume_id')
                            <div class="mt-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3">
                                <p class="text-red-400">{{ $message }}</p>
                            </div>
                        @enderror

                        @error('resume_file')
                            <div class="mt-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3">
                                <p class="text-red-400">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    {{-- JavaScript for handling resume selection --}}
                    <script>
                        function selectExistingResume(resumeId) {
                            document.getElementById('resume_id').value = resumeId;
                            document.getElementById('resume_file').value = '';
                            updateFileStatus('No file selected');
                            clearErrors();
                        }

                        function selectNewResume() {
                            document.getElementById('resume_id').value = '';
                            clearErrors();
                        }

                        function handleFileSelect() {
                            const fileInput = document.getElementById('resume_file');
                            const newResumeRadio = document.getElementById('new_resume_radio');

                            if (fileInput.files.length > 0) {
                                const file = fileInput.files[0];

                                newResumeRadio.checked = true;
                                document.getElementById('resume_id').value = '';
                                updateFileStatus(`File selected: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`);
                            } else {
                                updateFileStatus('No file selected');
                            }

                            clearErrors();
                        }

                        function resetForm() {
                            document.getElementById('resume_id').value = '';
                            document.getElementById('resume_file').value = '';

                            document.querySelectorAll('input[name="resume_option"]').forEach(radio => {
                                radio.checked = false;
                            });

                            updateFileStatus('No file selected');
                            clearErrors();

                            document.querySelectorAll('.alert').forEach(el => {
                                el.style.display = 'none';
                            });
                        }

                        function clearErrors() {
                            document.querySelectorAll('.error-message, .alert-danger, .alert-error').forEach(el => {
                                el.style.display = 'none';
                            });
                        }

                        function updateFileStatus(message) {
                            const statusElement = document.getElementById('file-status');
                            if (statusElement) {
                                statusElement.textContent = message;

                                statusElement.className = message.includes('selected') ?
                                    'text-sm text-green-400' :
                                    'text-sm text-gray-400';
                            }
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const resumeIdInput = document.getElementById('resume_id');
                            const fileInput = document.getElementById('resume_file');
                            const selectedOption = document.querySelector('input[name="resume_option"]:checked');
                            const newResumeRadio = document.getElementById('new_resume_radio');

                            if (fileInput && fileInput.files.length > 0) {
                                const file = fileInput.files[0];
                                updateFileStatus(`File selected: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`);
                                newResumeRadio.checked = true;
                                resumeIdInput.value = '';
                            } else if (resumeIdInput.value && selectedOption && selectedOption.value === 'existing') {
                                const existingRadio = document.querySelector(`input[data-resume-id="${resumeIdInput.value}"]`);
                                if (existingRadio) {
                                    existingRadio.checked = true;
                                    updateFileStatus('No file selected');
                                }
                            } else if (!selectedOption) {
                                resumeIdInput.value = '';
                                fileInput.value = '';
                                updateFileStatus('No file selected');
                            }
                        });

                        // منع إعادة إرسال النموذج عند تحديث الصفحة (PRG Pattern)
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>


                    {{-- Submit --}}

                    <div class="mt-10">

                        <button type="submit" id="submit-btn"
                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 py-4 text-lg font-semibold text-white transition hover:scale-[1.01] disabled:opacity-50">

                            Apply Now

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
