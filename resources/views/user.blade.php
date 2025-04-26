<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @php
        $role = Auth::user()->role;
    @endphp
    <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">{{ $title }} List</h1>
            @if ($role === 'Administrator')
                <div class="w-fit">
                    <x-secondary-button color='red-main'
                        data-open-modal="modalCreateUser"
                        data-type="create"
                        data-create-url="{{ route('user.store') }}"
                        data-target-form="formCreateUser"
                    >
                        <x-lucide-plus-circle class="w-5" />Create User
                    </x-secondary-button>
                </div>
            @endif
        </div>
        {{-- <div class="flex justify-between items-center">
            <div class="w-fit flex">
                <input type="text" name="" id="" placeholder="Search" autocomplete="off" required
                class="w-80 p-2 border-2 border-red-main text-sm rounded-l-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                <button class="px-3 py-2 bg-red-main text-white-main outline-none rounded-r-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">
                    <x-lucide-search class="w-6"></x-lucide-search>
                </button>
            </div>
            <div class="w-fit">
                <x-secondary-button color='red-main'
                    data-open-modal="modalCreateUser"
                    data-type="create"
                    data-create-url="{{ route('user.store') }}"
                    data-target-form="formCreateUser"
                >
                    <x-lucide-plus-circle class="w-5" />Create User
                </x-secondary-button>
            </div>
        </div> --}}
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Full Name</th>
                    <th class="border-b border-r" style="width: 20%">Username</th>
                    <th class="border-b border-r" style="width: 20%">Role</th>
                    <th class="border-b" style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $users->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2">{{ $user->full_name }}</td>
                        <td class="border border-white p-2 text-center">{{ $user->username }}</td>
                        <td class="border border-white p-2 text-center">{{ $user->role }}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalUserDetail"
                                    data-type="detail"
                                    data-user-id="{{ $user->user_id }}"
                                    data-full-name="{{ $user->full_name }}"
                                    data-username="{{ $user->username }}"
                                    data-role="{{ $user->role }}"
                                    data-created-at="{{ $user->created_at }}"
                                    data-updated-at="{{ $user->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                @if ($role === 'Administrator')
                                    |
                                    <x-icon-button color='yellow'
                                        data-open-modal="modalUpdateUser"
                                        data-type="update"
                                        data-update-url="{{ route('user.update', $user->user_id) }}"
                                        data-target-form="formUpdateUser"
                                        data-full-name="{{ $user->full_name }}"
                                        data-username="{{ $user->username }}"
                                        data-role="{{ $user->role }}"
                                    >
                                        <x-lucide-pen class="w-6" />
                                    </x-icon-button>
                                    |
                                    <x-icon-button color='red'
                                        data-open-modal="modalDeleteUser"
                                        data-type="delete"
                                        data-delete-url="{{ route('user.destroy', $user->user_id) }}"
                                    >
                                        <x-lucide-trash-2 class="w-6" />
                                    </x-icon-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="5">There is no data :(</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <td colspan="5">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>

    <x-modal id="modalCreateUser" title="Create User">
        <form method="POST" id="formCreateUser" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="fullName" class="font-bold text-sm w-fit">Full Name</label>
                <input type="text" name="fullName" id="fullName" placeholder="Full Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="username" class="font-bold text-sm w-fit">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="password" class="font-bold text-sm w-fit">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="role" class="font-bold text-sm w-fit">Role</label>
                <select name="role" id="role" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Role</option>
                    <option value="Administrator" class="bg-white">Administrator</option>
                    <option value="Waiter" class="bg-white">Waiter</option>
                    <option value="Cashier" class="bg-white">Cashier</option>
                    <option value="Owner" class="bg-white">Owner</option>
                </select>
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Create</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalUserDetail" title="User Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>User ID</p>
            <p>: <span id="modalUserId"></span></p>
            <p>Full Name</p>
            <p>: <span id="modalFullName"></span></p>
            <p>Username</p>
            <p>: <span id="modalUsername"></span></p>
            <p>Role</p>
            <p>: <span id="modalRole"></span></p>
            <p>Created At</p>
            <p>: <span id="modalCreatedAt"></span></p>
            <p>Updated At</p>
            <p>: <span id="modalUpdatedAt"></span></p>
        </div>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex justify-center items-center">
            <div class="w-30">
                <x-secondary-button color='red-main' type="button" data-close-modal>Close</x-secondary-button>
            </div>
        </div>
    </x-modal>

    <x-modal id="modalUpdateUser" title="Update User">
        <form method="POST" id="formUpdateUser" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label for="fullName" class="font-bold text-sm w-fit">Full Name</label>
                <input type="text" name="fullName" id="modalFullName" placeholder="Full Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="username" class="font-bold text-sm w-fit">Username</label>
                <input type="text" name="username" id="modalUsername" placeholder="Username" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="password" class="font-bold text-sm w-fit">Password</label>
                <input type="password" name="password" id="password" placeholder="********" autocomplete="off" required readonly
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main cursor-not-allowed transition">
            </div>
            <div class="flex flex-col">
                <label for="role" class="font-bold text-sm w-fit">Role</label>
                <select name="role" id="modalRole" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Role</option>
                    <option value="Administrator" class="bg-white">Administrator</option>
                    <option value="Waiter" class="bg-white">Waiter</option>
                    <option value="Cashier" class="bg-white">Cashier</option>
                    <option value="Owner" class="bg-white">Owner</option>
                </select>
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Update</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalDeleteUser" title="Delete User">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this user?</p>
        </div>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex gap-3">
            <div class="w-1/2">
                <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
            </div>
            <form method="POST" class="w-1/2" data-delete-form>
                @csrf
                @method('DELETE')
                <x-primary-button color='red-main' type='submit'>Delete</x-primary-button>
            </form>
        </div>
    </x-modal>
</x-layout>