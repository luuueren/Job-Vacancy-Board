<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">

                    Change User Password

                </h2>

                <p class="mt-1 text-sm text-gray-500">

                    Update the password for this user account.

                </p>

            </div>

            <a href="{{ route('user.index') }}"
                class="rounded-lg bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-300">

                ← Back to Users

            </a>

        </div>

    </x-slot>

    <div class="mx-auto max-w-3xl p-6">

        @if (session('success'))
            <div id="success-message"
                class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-700 transition-opacity duration-500">

                {{ session('success') }}

            </div>
        @endif

        <div class="rounded-xl bg-white shadow">

            <form action="{{ route('user.update', $user->id) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- User Information --}}
                <div class="border-b bg-gray-50 px-6 py-5">

                    <h3 class="text-lg font-bold text-gray-800">

                        User Information

                    </h3>

                    <p class="mt-1 text-sm text-gray-500">

                        These details are read-only.

                    </p>

                </div>

                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                    {{-- Name --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Full Name

                        </label>

                        <input type="text" value="{{ $user->name }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed">

                    </div>

                    {{-- Email --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Email Address

                        </label>

                        <input type="email" value="{{ $user->email }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed">

                    </div>

                    {{-- Role --}}
                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            User Role

                        </label>

                        <input type="text" value="{{ ucwords(str_replace('-', ' ', $user->role)) }}" readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed">

                    </div>

                </div> {{-- Password Section --}}
                <div class="border-t bg-gray-50 px-6 py-5">

                    <h3 class="text-lg font-bold text-gray-800">

                        Change Password

                    </h3>

                    <p class="mt-1 text-sm text-gray-500">

                        Enter a new password for this user.

                    </p>

                </div>

                <div class="space-y-6 p-6">

                    {{-- New Password --}}
                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">

                            New Password

                        </label>

                        <div class="relative">

                            <input id="password" name="password" type="password" placeholder="Enter new password"
                                class="w-full rounded-lg border-gray-300 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

                                👁

                            </button>

                        </div>

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">

                                {{ $message }}

                            </p>
                        @enderror

                    </div>

                    {{-- Confirm Password --}}
                    <div>

                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">

                            Confirm Password

                        </label>

                        <div class="relative">

                            <input id="password_confirmation" name="password_confirmation" type="password"
                                placeholder="Confirm new password"
                                class="w-full rounded-lg border-gray-300 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            <button type="button" id="toggleConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

                                👁

                            </button>

                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-2">

                        <a href="{{ route('user.index') }}"
                            class="rounded-lg bg-gray-200 px-5 py-2.5 font-semibold text-gray-700 transition hover:bg-gray-300">

                            Cancel

                        </a>

                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2.5 font-semibold text-white transition hover:bg-indigo-700">

                            Update Password

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>
        function toggleVisibility(inputId, buttonId) {

            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);

            button.addEventListener('click', function() {

                input.type = input.type === 'password' ?
                    'text' :
                    'password';

                button.textContent = input.type === 'password' ?
                    '👁' :
                    '🙈';

            });

        }

        toggleVisibility('password', 'togglePassword');
        toggleVisibility('password_confirmation', 'toggleConfirmPassword');
    </script>
    {{-- <script>
        const successMessage = document.getElementById('success-message');

        if (successMessage) {

            setTimeout(() => {

                successMessage.style.opacity = '0';

                setTimeout(() => {

                    successMessage.remove();

                }, 500);

            }, 3000);

        }
    </script> --}}

</x-app-layout>
