<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Add Company
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Create a new company and assign its owner.
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

            <form action="{{ route('company.store') }}" method="POST">

                @csrf

                <!-- ========================= -->
                <!-- Company Information Card -->
                <!-- ========================= -->

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">

                    <div class="px-6 py-5 bg-gray-50 border-b">

                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            🏢 Company Information
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Fill in the basic information about the company.
                        </p>

                    </div>

                    <div class="p-6">

                        <!-- Company Name -->
                        <div class="mb-6">

                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Company Name
                            </label>

                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Google LLC"
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

                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                placeholder="Company Address"
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

                                <option value="">
                                    Select Industry
                                </option>

                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}"
                                        {{ old('industry') == $industry ? 'selected' : '' }}>
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

                            <input type="url" id="website" name="website" value="{{ old('website') }}"
                                placeholder="https://company.com"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('website')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                <!-- ===================== -->
                <!-- Company Owner Card -->
                <!-- ===================== -->

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                    <div class="px-6 py-5 bg-gray-50 border-b">

                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            👤 Company Owner
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Create the account that will manage this company.
                        </p>

                    </div>

                    <div class="p-6">

                        <!-- Owner Name -->
                        <div class="mb-6">

                            <label for="owner_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Name
                            </label>

                            <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}"
                                placeholder="John Smith"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('owner_name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Owner Email -->
                        <div class="mb-6">

                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Email
                            </label>

                            <input type="email" id="email" name="owner_email" value="{{ old('owner_email') }}"
                                placeholder="owner@example.com"
                                class="w-full rounded-lg border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">

                            @error('owner_email')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>
                        <!-- Owner Password -->
                        <div class="mb-6">

                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Password
                            </label>

                            <div class="relative">

                                <input type="password" id="password" name="owner_password"
                                    value="{{ old('owner_password') }}" placeholder="Create a secure password"
                                    class="w-full rounded-lg border-gray-300 shadow-sm pr-12
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                <!-- Toggle Password -->
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-indigo-600">

                                    <!-- Eye -->
                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5
                                               12 5c4.478 0 8.268 2.943
                                               9.542 7-1.274 4.057-5.064
                                               7-9.542 7-4.477 0-8.268-2.943
                                               -9.542-7z" />
                                    </svg>

                                    <!-- Eye Slash -->
                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112
                                               19c-4.478 0-8.268-2.943-9.542-7
                                               a9.97 9.97 0 012.442-4.362m3.21-2.54
                                               A9.956 9.956 0 0112 5c4.478 0
                                               8.268 2.943 9.542 7a9.97
                                               9.97 0 01-1.249 2.592M15
                                               12a3 3 0 00-3-3m0 0a3
                                               3 0 00-2.83 2M3
                                               3l18 18" />
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

                <!-- Buttons -->
                <div class="flex items-center justify-between mt-8">

                    <a href="{{ route('company.index') }}"
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

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />

                        </svg>

                        Add Company

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function() {

            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');

        });
    </script>

</x-app-layout>
