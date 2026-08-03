<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white min-h-screen relative overflow-x-hidden overflow-y-auto">

    <!-- Background -->
    <div class="fixed inset-0 overflow-hidden -z-10">

        <div
            class="absolute top-[15%] left-[-10%] md:left-[-5%] w-[600px] h-[140px] rotate-12 bg-indigo-500/15 blur-3xl rounded-full">
        </div>

        <div
            class="absolute top-[70%] right-[-5%] md:right-0 w-[500px] h-[120px] -rotate-12 bg-rose-500/15 blur-3xl rounded-full">
        </div>

        <div class="absolute bottom-[5%] left-[8%] w-[300px] h-[80px] -rotate-6 bg-violet-500/15 blur-3xl rounded-full">
        </div>

        <div class="absolute top-[10%] right-[20%] w-[200px] h-[60px] rotate-12 bg-amber-500/15 blur-3xl rounded-full">
        </div>

        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/80"></div>

    </div>

    <!-- Content -->
    <div class="relative z-10 flex min-h-screen w-full flex-col items-center py-10 px-6" x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 250)">

        <!-- Logo -->
        <div class="mb-8" x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

            <a href="{{ url('/') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-300 hover:text-white transition" />
            </a>

        </div>

        <!-- Card -->
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full max-w-md rounded-2xl border border-white/10 bg-gray-900/70 backdrop-blur-xl p-8 shadow-2xl">

            {{ $slot }}

        </div>

    </div>

</body>

</html>
