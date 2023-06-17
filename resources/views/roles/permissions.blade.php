<x-app-layout>
    <x-slot name="header">
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full group">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Role Permissions') }}
                </h2>
            </div>
            <div class="relative z-0 w-full group">
                @can('roles lists')
                    <a href="{{ url('roles/lists') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-4 float-right">Back
                        to List</a>
                @endcan
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="text-md font-bold text-slate-900 mb-1">{{ $roles->name }}</h2>
                            <p class="text-sm font-semibold text-slate-900 mb-5">{{ $roles->description }}</p>
                            <form action="{{ url('roles/update-permissions', $roles->id) }}" method="post">
                                @csrf
                                @if ($permissions)
                                    @foreach ($permissions as $key => $permission)
                                        <div class="grid md:grid-cols-4 md:gap-6  mt-3">
                                            <div class="relative z-0 w-full mb-1 group">
                                                <div class="flex items-center mb-0">
                                                    <label for="permission-{{ $key }}"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        {{ strtoupper($key) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($permission)
                                            <div class="grid md:grid-cols-8 md:gap-6 mt-2">
                                                @foreach ($permission as $key1 => $val)
                                                    <div class="relative z-0 w-full group">
                                                        <div class="flex items-center mb-3">
                                                            <label
                                                                for="permission-{{ $key }}-{{ $key1 }}"
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                <input name="permissions[]"
                                                                    id="permission-{{ $key }}-{{ $key1 }}"
                                                                    {{ in_array($key . ' ' . $val, $role_permissions) ? 'checked' : '' }}
                                                                    type="checkbox"
                                                                    value="{{ $key }} {{ $val }}"
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                                {{ count($permission) > 1 ? strtoupper($val) : strtoupper($key) }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <hr />
                                    @endforeach
                                @endif

                                <div class="relative z-0 w-full my-4 group">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Update
                                        Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
