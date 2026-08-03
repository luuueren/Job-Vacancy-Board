<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            Job Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Welcome --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-white">
                    Welcome, {{ auth()->user()->name }}
                </h1>

                <p class="mt-2 text-gray-400">
                    Find your next opportunity.
                </p>

            </div>

            {{-- Search --}}
            <div class="flex flex-col md:flex-row gap-4 justify-between mb-8">

                <input type="text" placeholder="Search jobs..."
                    class="w-full md:w-96 rounded-lg border border-zinc-700 bg-zinc-900 text-white placeholder:text-gray-500 focus:border-indigo-500 focus:ring-indigo-500">

                <div class="flex gap-2">

                    <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700">
                        All
                    </button>

                    <button class="px-4 py-2 rounded-lg border border-zinc-700 hover:bg-zinc-800">
                        Full Time
                    </button>

                    <button class="px-4 py-2 rounded-lg border border-zinc-700 hover:bg-zinc-800">
                        Contract
                    </button>

                    <button class="px-4 py-2 rounded-lg border border-zinc-700 hover:bg-zinc-800">
                        Remote
                    </button>

                    <button class="px-4 py-2 rounded-lg border border-zinc-700 hover:bg-zinc-800">
                        Hybrid
                    </button>

                </div>

            </div>

            {{-- Jobs --}}

            <div class="space-y-5">

                @forelse($jobs as $job)
                    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-6 hover:border-indigo-500 transition">

                        <div class="flex justify-between items-start">

                            <div>

                                <h2 class="text-xl font-bold text-white">
                                    {{ $job->title }}
                                </h2>

                                <p class="mt-1 text-gray-400">
                                    {{ $job->company?->name }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $job->location }}
                                </p>

                                <p class="mt-4 font-semibold text-green-400">
                                    ${{ number_format($job->salary, 2) }}
                                </p>

                            </div>

                            <span class="rounded-full bg-indigo-600 px-4 py-1 text-sm">

                                {{ $job->type }}

                            </span>

                        </div>

                        <div class="mt-6 flex justify-end">

                            <a href="#"
                                class="rounded-lg bg-white text-black px-5 py-2 font-semibold hover:bg-gray-200">

                                View Details

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl bg-zinc-900 p-10 text-center">

                        <h3 class="text-xl font-semibold text-white">
                            No jobs available
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Please check back later.
                        </p>

                    </div>
                @endforelse

            </div>

            <div class="mt-8">

                {{ $jobs->links() }}

            </div>

        </div>
    </div>

</x-app-layout>
