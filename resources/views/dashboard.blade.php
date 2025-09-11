<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
       <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <div class="rounded-lg  dark:bg-gray-900 p-4 border-t-2 border-blue-300 shadow-sm border border-neutral-200">
                <p class="text-sm text-gray-900">Total Users</p>
                <p class="text-2xl font-semibold text-sm text-gray-900">47</p>
            </div>

            <div class="rounded-lg  dark:bg-gray-900 p-4 border-t-2 border-blue-300 shadow-sm border border-neutral-200">
                <p class="text-sm text-gray-900">Total Booking Templates</p>
                <p class="text-2xl font-semibold text-sm text-gray-900">25</p>
            </div>
            <div class="rounded-lg  dark:bg-gray-900 p-4 border-t-2 border-blue-300 shadow-sm border border-neutral-200">
                <p class="text-sm text-gray-900">Total Services</p>
                <p class="text-2xl font-semibold text-sm text-gray-900">12</p>
            </div>
    </div>

        <div class="border border-neutral-200 p-6 rounded-xl mx-auto w-full max-w-6xl ">
            <h4 class="text-lg font-semibold text-center text-gray-800 dark:text-gray-200 mb-4">Users Information</h4>
                <hr>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-900 dark:text-gray-900">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Roles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="odd: odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                                <td class="px-6 py-2 text-gray-900 dark:bg-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($user->roles as $role)
                                            <flux:badge>{{ $role->name }}</flux:badge>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
