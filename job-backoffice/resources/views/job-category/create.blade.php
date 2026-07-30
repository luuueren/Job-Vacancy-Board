<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Category') }}
        </h2>
    </x-slot>


    <div class="p-6">

        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">

            <form action="{{ route('category.store') }}" method="POST">

                @csrf

                <!-- Category Name -->
                <div class="mb-6">

                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name
                    </label>


                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Enter category name"
                        class="w-full rounded-md border-gray-300 shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        required>


                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('category.index') }}"
                        class="inline-flex items-center px-4 py-2
                               bg-gray-200 border border-transparent
                               rounded-md font-semibold text-xs
                               text-gray-700 uppercase tracking-widest
                               hover:bg-gray-300
                               focus:outline-none focus:ring-2
                               focus:ring-gray-400 focus:ring-offset-2
                               transition ease-in-out duration-150">
                        Cancel
                    </a>


                    <button type="submit"
                        class="inline-flex items-center px-4 py-2
                               bg-indigo-600 border border-transparent
                               rounded-md font-semibold text-xs
                               text-white uppercase tracking-widest
                               hover:bg-indigo-700
                               focus:outline-none focus:ring-2
                               focus:ring-indigo-500 focus:ring-offset-2
                               transition ease-in-out duration-150">
                        Add Category
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
