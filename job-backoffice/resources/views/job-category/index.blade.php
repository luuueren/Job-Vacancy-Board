<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>


    <div class="p-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div id="success-message"
                class="mb-6 flex items-center justify-between
                       rounded-lg border border-green-200
                       bg-green-50 px-4 py-3
                       text-green-800 shadow-sm
                       transition-opacity duration-500"
                role="alert">

                <div class="flex items-center gap-2">

                    <span class="text-lg">
                        ✅
                    </span>

                    <span class="font-medium">
                        {{ session('success') }}
                    </span>

                </div>


                <button type="button" onclick="closeSuccessMessage()"
                    class="text-xl text-green-700 hover:text-green-900" aria-label="Close">
                    &times;
                </button>

            </div>
        @endif


        {{-- Header Actions --}}
        <div class="mb-6 flex justify-end">

            <a href="{{ route('category.create') }}"
                class="inline-flex items-center rounded-md
                       bg-blue-600 px-4 py-2
                       font-semibold text-white
                       shadow-sm transition
                       hover:bg-blue-700
                       focus:outline-none
                       focus:ring-2
                       focus:ring-blue-500
                       focus:ring-offset-2">
                + Add Job Category
            </a>

        </div>


        {{-- Categories Table --}}
        <div class="overflow-x-auto rounded-lg shadow">

            <table class="min-w-full divide-y divide-gray-200 bg-white">

                <thead class="bg-gray-50">

                    <tr>

                        <th scope="col"
                            class="px-6 py-3 text-left
                                   text-xs font-medium
                                   uppercase tracking-wider
                                   text-gray-500">
                            Category Name
                        </th>


                        <th scope="col"
                            class="px-6 py-3 text-left
                                   text-xs font-medium
                                   uppercase tracking-wider
                                   text-gray-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse ($categories as $category)
                        <tr class="transition hover:bg-gray-50">

                            <td
                                class="whitespace-nowrap
                                       px-6 py-4
                                       text-sm font-medium
                                       text-gray-900">
                                {{ $category->name }}
                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                {{-- Edit --}}
                                <a href="{{ route('category.edit', $category->id) }}"
                                    class="mr-4 text-indigo-600
                                           hover:text-indigo-900">
                                    ✍️ Edit
                                </a>


                                {{-- Archive --}}
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                    class="inline">

                                    @csrf

                                    @method('DELETE')


                                    <button type="submit"
                                        class="text-red-600
                                               hover:text-red-900"
                                        onclick="return confirm(
                                            'Are you sure you want to archive this category?'
                                        )">
                                        🗃️ Archive
                                    </button>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="2"
                                class="px-6 py-8
                                       text-center
                                       text-gray-500">
                                No job categories found.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($categories->hasPages())
            <div class="mt-6">

                {{ $categories->links() }}

            </div>
        @endif

    </div>


    {{-- Auto-hide Success Message --}}
    <script>
        function closeSuccessMessage() {

            const successMessage =
                document.getElementById('success-message');

            if (successMessage) {

                successMessage.classList.add('opacity-0');

                setTimeout(() => {

                    successMessage.remove();

                }, 500);

            }

        }


        // Hide the message automatically after 5 seconds

        setTimeout(() => {

            closeSuccessMessage();

        }, 5000);
    </script>

</x-app-layout>
