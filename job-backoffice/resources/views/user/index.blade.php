<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">

                    {{ request()->boolean('archived') ? 'Archived Users' : 'Users' }}

                </h2>

                <p class="mt-1 text-sm text-gray-500">

                    Manage all registered users in the system.

                </p>

            </div>

            <div>

                @if (!request()->boolean('archived'))
                    <a href="{{ route('user.create') }}"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">

                        + Add User

                    </a>
                @else
                    <a href="{{ route('user.index') }}"
                        class="rounded-lg bg-gray-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">

                        ← Active Users

                    </a>
                @endif

            </div>

        </div>

    </x-slot>

    <div class="mx-auto max-w-7xl p-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-700">

                {{ session('success') }}

            </div>
        @endif

        {{-- Card --}}
        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="flex items-center justify-between border-b bg-gray-50 px-6 py-4">

                <h3 class="text-lg font-bold text-gray-800">

                    User List

                </h3>

                @if (!request()->boolean('archived'))
                    <a href="{{ route('user.index', ['archived' => true]) }}"
                        class="rounded-lg bg-yellow-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-yellow-600">

                        🗃 View Archived Users

                    </a>
                @endif

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Name
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Role
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Joined
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-600">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">

                        @forelse($users as $user)
                            <tr class="transition hover:bg-gray-50">

                                {{-- Name --}}
                                <td class="px-6 py-4">

                                    @if (request()->boolean('archived'))
                                        <span class="font-semibold text-gray-500">

                                            {{ $user->name }}

                                        </span>
                                    @else
                                        <a href="{{ route('user.show', $user->id) }}"
                                            class="font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">

                                            {{ $user->name }}

                                        </a>
                                    @endif

                                </td>

                                {{-- Email --}}
                                <td class="px-6 py-4 text-gray-700">

                                    {{ $user->email }}

                                </td> {{-- Role --}}
                                <td class="px-6 py-4">

                                    @switch($user->role)
                                        @case('super-admin')
                                            <span
                                                class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Super Admin
                                            </span>
                                        @break

                                        @case('admin')
                                            <span
                                                class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                                Admin
                                            </span>
                                        @break

                                        @case('company-owner')
                                            <span
                                                class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                                Company Owner
                                            </span>
                                        @break

                                        @case('job-seeker')
                                            <span
                                                class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                Job Seeker
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                    @endswitch

                                </td>

                                {{-- Joined Date --}}
                                <td class="px-6 py-4 text-sm text-gray-700">

                                    {{ $user->created_at->format('d M Y') }}

                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">

                                    @if (!request()->boolean('archived'))
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="mr-5 font-medium text-indigo-600 hover:text-indigo-900">
                                            ✏️ Edit
                                        </a>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            class="inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="font-medium text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to archive this user?')">

                                                🗃️ Archive

                                            </button>

                                        </form>
                                    @else
                                        <form action="{{ route('user.restore', $user->id) }}" method="POST"
                                            class="inline">

                                            @csrf
                                            @method('PUT')

                                            <button type="submit"
                                                class="mr-5 font-medium text-green-600 hover:text-green-900"
                                                onclick="return confirm('Are you sure you want to restore this user?')">

                                                ♻️ Restore

                                            </button>

                                        </form>

                                        <span class="font-medium text-gray-400">
                                            Archived
                                        </span>
                                    @endif

                                </td>

                            </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">

                                        No users found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="border-t bg-white px-6 py-4">

                    {{ $users->links() }}

                </div>

            </div>

        </div>

    </x-app-layout>
