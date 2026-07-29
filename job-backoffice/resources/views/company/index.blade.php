<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->boolean('archived') ? __('Archived Companies') : __('Companies') }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div id="success-message"
                class="mb-6 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm transition-opacity duration-500">

                <div class="flex items-center gap-2">
                    <span class="text-lg">✅</span>
                    <span class="font-medium">
                        {{ session('success') }}
                    </span>
                </div>

                <button type="button" onclick="closeSuccessMessage()"
                    class="text-xl text-green-700 hover:text-green-900">
                    &times;
                </button>

            </div>
        @endif


        {{-- Header Actions --}}
        <div class="mb-6 flex items-center justify-between">

            @if (request()->boolean('archived'))
                <a href="{{ route('company.index') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2 font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    📂
                    <span>Active Companies</span>
                </a>
            @else
                <a href="{{ route('company.index', ['archived' => true]) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-gray-700 px-4 py-2 font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    🗃️
                    <span>View Archived Companies</span>
                </a>

                <a href="{{ route('company.create') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    ➕
                    <span>Add Company</span>
                </a>
            @endif

        </div>


        {{-- Companies Table --}}
        <div class="overflow-hidden rounded-lg bg-white shadow">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Name
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Website
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Address
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Industry
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">

                    @forelse($companies as $company)
                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (request()->input('archived'))
                                    <span class="text-sm text-gray-500">
                                        {{ $company->name }}
                                    </span>
                                @else
                                    <a href="{{ route('company.show', $company->id) }}"
                                        class="text-sm font-semibold text-indigo-600 transition-colors duration-200 hover:text-indigo-800 hover:underline">
                                        {{ $company->name }}
                                    </a>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                                    class="text-sm text-blue-600 transition-colors duration-200 hover:text-blue-800 hover:underline">
                                    {{ $company->website }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $company->address }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                    {{ $company->industry }}
                                </span>
                            </td>

                            <td class="px-6 py-4">

                                @if (!request()->boolean('archived'))
                                    {{-- Edit --}}
                                    <a href="{{ route('company.edit', $company->id) }}"
                                        class="mr-5 font-medium text-indigo-600 hover:text-indigo-900">
                                        ✏️ Edit
                                    </a>


                                    {{-- Archive --}}
                                    <form action="{{ route('company.destroy', $company->id) }}" method="POST"
                                        class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="font-medium text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to archive this company?')">
                                            🗃️ Archive
                                        </button>

                                    </form>
                                @else
                                    {{-- Restore --}}
                                    <form action="{{ route('company.restore', $company->id) }}" method="POST"
                                        class="inline">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="mr-5 font-medium text-green-600 hover:text-green-900"
                                            onclick="return confirm('Are you sure you want to restore this company?')">
                                            ♻️ Restore
                                        </button>

                                    </form>


                                    {{-- Permanent Delete (Future) --}}
                                    <span class="font-medium text-gray-400">
                                        Archived
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-gray-500">
                                No companies found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($companies->hasPages())
            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        @endif

    </div>


    {{-- Auto Hide Success Message --}}
    <script>
        function closeSuccessMessage() {

            const successMessage = document.getElementById('success-message');

            if (successMessage) {

                successMessage.classList.add('opacity-0');

                setTimeout(() => {
                    successMessage.remove();
                }, 500);

            }
        }

        setTimeout(() => {
            closeSuccessMessage();
        }, 5000);
    </script>

</x-app-layout>
