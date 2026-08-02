<x-main-layout title="Shaghalni - Find Your Dream Job">

    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" class="max-w-5xl mx-auto px-6 text-center">

        {{-- Badge --}}
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" class="mb-6">

            <span
                class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-white/70 backdrop-blur">
                🚀 Shaghalni
            </span>

        </div>

        {{-- Heading --}}
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-150"
            x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">

            <h1 class="text-5xl font-bold tracking-tight text-white sm:text-6xl md:text-8xl">

                Find Your

                <br>

                <span class="font-serif italic text-white/60">
                    Dream Job
                </span>

            </h1>

        </div>

        {{-- Description --}}
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-300"
            x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-8">

            <p class="mx-auto max-w-2xl text-lg leading-relaxed text-white/60">

                Discover thousands of career opportunities, connect with top employers,
                and take the next step toward building your future.

            </p>

        </div>

        {{-- Buttons --}}
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-500"
            x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">

            <a href="{{ route('register') }}"
                class="rounded-xl bg-white px-6 py-3 font-semibold text-black transition hover:scale-105 hover:bg-gray-200">

                Create an Account

            </a>

            <a href="{{ route('login') }}"
                class="rounded-xl border border-white/20 bg-white/10 px-6 py-3 font-semibold text-white backdrop-blur transition hover:scale-105 hover:bg-white/20">

                Login

            </a>

        </div>

    </div>

</x-main-layout>
