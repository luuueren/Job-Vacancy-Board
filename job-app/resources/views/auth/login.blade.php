<x-guest-layout>

    <div class="mb-8 text-center">

        <h1 class="text-3xl font-bold text-white">

            Welcome Back

        </h1>

        <p class="mt-2 text-sm text-white/60">

            Sign in to continue your job search.

        </p>

    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">

        @csrf

        {{-- Email --}}
        <div>

            <x-input-label for="email" :value="__('Email Address')" class="text-white" />

            <x-text-input id="email"
                class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white placeholder-white/40"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="john@example.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />

        </div>

        {{-- Password --}}
        <div>

            <x-input-label for="password" :value="__('Password')" class="text-white" />

            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

        </div>

        {{-- Remember Me --}}
        <label class="flex items-center gap-3">

            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-white/20 bg-white/5 text-indigo-600 focus:ring-indigo-500">

            <span class="text-sm text-white/70">

                Remember me

            </span>

        </label>

        <button type="submit"
            class="w-full rounded-xl bg-white py-3 font-semibold text-black transition hover:bg-gray-200">

            Login

        </button>

        <div class="flex items-center justify-between text-sm">

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-white/60 hover:text-white">

                    Forgot password?

                </a>
            @endif

            <a href="{{ route('register') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">

                Create Account

            </a>

        </div>

    </form>

</x-guest-layout>
