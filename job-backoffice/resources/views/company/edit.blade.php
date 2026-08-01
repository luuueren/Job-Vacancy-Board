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

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('company.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition">

                    ← Back to Companies

                </a>
            @endif

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-6">

            <form
                action="{{ auth()->user()->role === 'admin' ? route('company.update', $company->id) : route('my-company.update') }}"
                method="POST">

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

                    {{-- ===================== --}}
                    {{-- Company Owner Card (Admin Only) --}}
                    {{-- ===================== --}}
                    @if (auth()->user()->role === 'admin')
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

                            <div class="px-6 py-5 bg-gray-50 border-b">

                                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    👤 Company Owner
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Update the company owner's information.
                                </p>

                            </div>

                            <div class="p-6">

                                {{-- Owner Name --}}
                                <div class="mb-6">

                                    <label for="owner_name" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Owner Name
                                    </label>

                                    <input type="text" id="owner_name" name="owner_name"
                                        value="{{ old('owner_name', $company->owner->name) }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>

                                    @error('owner_name')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- Owner Email --}}
                                <div class="mb-6">

                                    <label for="owner_email" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Owner Email
                                    </label>

                                    <input type="email" id="owner_email" value="{{ $company->owner->email }}"
                                        disabled
                                        class="w-full cursor-not-allowed rounded-lg border-gray-300 bg-gray-100 text-gray-500 shadow-sm">

                                    <p class="mt-2 text-xs text-gray-500">
                                        The owner's email cannot be changed.
                                    </p>

                                </div>

                                {{-- Owner Password --}}
                                <div>

                                    <label for="owner_password" class="mb-2 block text-sm font-semibold text-gray-700">
                                        New Password
                                        <span class="font-normal text-gray-400">
                                            (Leave blank to keep current password)
                                        </span>
                                    </label>

                                    <div class="relative">

                                        <input type="password" id="owner_password" name="owner_password"
                                            class="w-full rounded-lg border-gray-300 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                        <button type="button" id="togglePassword"
                                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-indigo-600">

                                            {{-- SVG كما هو بدون تعديل --}}
                                            ...
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
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex items-center justify-between pb-6 pl-6 pr-6">

                        <a href="{{ auth()->user()->role === 'admin' ? route('company.index') : route('my-company.show') }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100">

                            Cancel

                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow transition hover:bg-indigo-700">

                            💾 Update Company

                        </button>

                    </div>

                    <script>
                        const passwordInput = document.getElementById('owner_password');
                        const togglePassword = document.getElementById('togglePassword');
                        const eyeOpen = document.getElementById('eyeOpen');
                        const eyeClosed = document.getElementById('eyeClosed');

                        if (passwordInput && togglePassword) {

                            togglePassword.addEventListener('click', () => {

                                passwordInput.type =
                                    passwordInput.type === 'password' ?
                                    'text' :
                                    'password';

                                eyeOpen.classList.toggle('hidden');
                                eyeClosed.classList.toggle('hidden');

                            });

                        }
                    </script>

</x-app-layout>
