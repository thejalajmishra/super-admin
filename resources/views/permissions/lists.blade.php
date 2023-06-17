<x-app-layout>
    <x-slot name="header">
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full group">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Permissions') }}
                </h2>
            </div>
            <div class="relative z-0 w-full group">
                @can('permissions create')
                    <a href="{{ url('permissions/create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-4 float-right">Add
                        New permission</a>
                @endcan
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Guard
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Created On
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Updated On
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($permissions)
                                @foreach ($permissions as $key => $permission)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-2">
                                            {{ $key + 1 }}
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $permission->name }}
                                        </th>
                                        <td class="px-6 py-2">
                                            {{ $permission->description }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $permission->guard_name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $permission->created_at }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $permission->updated_at }}
                                        </td>
                                        <td class="flex items-center px-6 py-2 space-x-3">
                                            @can('permissions update')
                                                <a href="{{ url('permissions/' . $permission->id . '/edit') }}"
                                                    class="inline-flex items-center px-4 py-1 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 m-4">Edit</a>
                                            @endcan
                                            @can('permissions delete')
                                                <a href="{{ url('' . $permission->id . '/delete') }}"
                                                    class="inline-flex items-center justify-center px-4 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Remove</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $permissions->links() !!}
        </div>
    </div>
</x-app-layout>
