<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Edit Company
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Update the information for <span class="font-medium">{{ $company->name }}</span>.
                </p>
            </div>

            <a href="{{ route('company.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg
                       text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                ← Back to Companies
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-6">

            <form action="{{ route('company.update', $company->id) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- ========================= -->
                <!-- Company Information Card -->
                <!-- ========================= -->

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">

                    <div class="px-6 py-5 bg-gray-50 border-b">

                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            🏢 Company Information
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Update the company's basic information.
                        </p>

                    </div>

                    <div class="p-6">

                        <!-- Company Name -->
                        <div class="mb-6">

                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Company Name
                            </label>

                            <input type="text" id="name" name="name"
                                value="{{ old('name', $company->name) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Address -->
                        <div class="mb-6">

                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Address
                            </label>

                            <input type="text" id="address" name="address"
                                value="{{ old('address', $company->address) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('address')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Industry -->
                        <div class="mb-6">

                            <label for="industry" class="block text-sm font-semibold text-gray-700 mb-2">
                                Industry
                            </label>

                            <select id="industry" name="industry"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}"
                                        {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>

                                        {{ $industry }}

                                    </option>
                                @endforeach

                            </select>

                            @error('industry')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Website -->
                        <div>

                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">

                                Website
                                <span class="text-gray-400 font-normal">(Optional)</span>

                            </label>

                            <input type="url" id="website" name="website"
                                value="{{ old('website', $company->website) }}" placeholder="https://company.com"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('website')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div> <!-- ===================== -->
                <!-- Company Owner Card -->
                <!-- ===================== -->

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                    <div class="px-6 py-5 bg-gray-50 border-b">

                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            👤 Company Owner
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Update the company owner's information.
                        </p>

                    </div>

                    <div class="p-6">

                        <!-- Owner Name -->
                        <div class="mb-6">

                            <label for="owner_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Name
                            </label>

                            <input type="text" id="owner_name" name="owner_name"
                                value="{{ old('owner_name', $company->owner->name) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm
               focus:border-indigo-500 focus:ring-indigo-500"
                                required>

                            @error('owner_name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Owner Email -->
                        <div class="mb-6">

                            <label for="owner_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Email
                            </label>

                            <input type="email" id="owner_email" value="{{ $company->owner->email }}" disabled
                                class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500
                            cursor-not-allowed shadow-sm">

                            <p class="mt-2 text-xs text-gray-500">
                                The owner's email cannot be changed.
                            </p>

                        </div>

                        <!-- Owner Password -->
                        <div>

                            <label for="owner_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                                <span class="text-gray-400 font-normal">(Leave blank to keep current password)</span>
                            </label>

                            <div class="relative">

                                <input type="password" id="owner_password" name="owner_password"
                                    class="w-full rounded-lg border-gray-300 shadow-sm pr-12
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-indigo-600">

                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5
                                            12 5c4.478 0 8.268 2.943
                                            9.542 7-1.274 4.057-5.064
                                            7-9.542 7-4.477 0-8.268-2.943
                                            -9.542-7z" />

                                    </svg>

                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.584 10.587A2 2 0 0013.414
                                            13.417M9.878 5.092A9.953 9.953 0 0112
                                            5c4.478 0 8.268 2.943 9.542
                                            7a9.97 9.97 0 01-1.563
                                            3.029M6.228 6.228A9.956
                                            9.956 0 002.458 12c1.274
                                            4.057 5.064 7 9.542 7
                                            1.524 0 2.97-.34
                                            4.272-.949" />

                                    </svg>

                                </button>

                            </div>

                            @error('owner_password')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                <!-- Action Buttons -->

                <div class="flex items-center justify-between mt-8">

                    <a href="{{ route('company.index') }}"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg
                               border border-gray-300 bg-white
                               text-gray-700 text-sm font-medium
                               hover:bg-gray-100 transition">

                        Cancel

                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2
                               px-6 py-2.5 rounded-lg
                               bg-indigo-600 text-white
                               text-sm font-semibold
                               hover:bg-indigo-700 transition shadow">

                        💾 Update Company

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        const passwordInput = document.getElementById('owner_password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', () => {

            passwordInput.type =
                passwordInput.type === 'password' ?
                'text' :
                'password';

            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');

        });
    </script>

</x-app-layout>
