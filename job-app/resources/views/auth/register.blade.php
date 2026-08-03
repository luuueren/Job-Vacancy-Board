<x-guest-layout>

    <div class="mb-8 text-center">

        <h1 class="text-3xl font-bold text-white">
            Create Account
        </h1>

        <p class="mt-2 text-sm text-white/60">
            Join Shaghalni and start applying for your dream job.
        </p>

    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">

        @csrf

        {{-- Name --}}
        <div>

            <x-input-label for="name" :value="__('Full Name')" class="text-white" />

            <x-text-input id="name"
                class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white placeholder-white/40 focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="John Doe" />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />

        </div>

        {{-- Email --}}
        <div>

            <x-input-label for="email" :value="__('Email Address')" class="text-white" />

            <x-text-input id="email"
                class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white placeholder-white/40"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="john@example.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />

        </div>

        {{-- Password --}}
        <div>

            <x-input-label for="password" :value="__('Password')" class="text-white" />

            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

        </div>

        {{-- Confirm Password --}}
        <div>

            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />

            <x-text-input id="password_confirmation"
                class="mt-2 block w-full rounded-lg border-white/10 bg-white/5 text-white" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        </div>

        <button type="submit"
            class="w-full rounded-xl bg-white py-3 font-semibold text-black transition hover:bg-gray-200">

            Create Account

        </button>

        <p class="text-center text-sm text-white/60">

            Already have an account?

            <a href="{{ route('login') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">

                Login

            </a>

        </p>

    </form>

</x-guest-layout>
