<x-layout>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    @php
        $role = Auth::user()->role;
    @endphp
    <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">{{ $title }} List</h1>
            @if ($role === 'Administrator' || $role === 'Waiter')
                <div class="w-fit">
                    <x-secondary-button color='red-main'
                        data-open-modal="modalAddMenu"
                        data-type="create"
                        data-create-url="{{ route('menu.store') }}"
                        data-target-form="formAddMenu"
                    >
                        <x-lucide-plus-circle class="w-5" />Add Menu
                    </x-secondary-button>
                </div>
            @endif
        </div>
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Menu Name</th>
                    <th class="border-b border-r" style="width: 30%">Price /piece</th>
                    <th class="border-b" style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $menu)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $menus->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2 text-center">{{ $menu->menu_name }}</td>
                        <td class="border border-white p-2 text-center">${{ $menu->price }}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalMenuDetail"
                                    data-type="detail"
                                    data-menu-id="{{ $menu->menu_id }}"
                                    data-menu-name="{{ $menu->menu_name }}"
                                    data-price="{{ $menu->price }}"
                                    data-created-at="{{ $menu->created_at }}"
                                    data-updated-at="{{ $menu->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                @if ($role === 'Administrator' || $role === 'Waiter')
                                    |
                                    <x-icon-button color='yellow'
                                        data-open-modal="modalUpdateMenu"
                                        data-type="update"
                                        data-update-url="{{ route('menu.update', $menu->menu_id) }}"
                                        data-target-form="formUpdateMenu"
                                        data-menu-name="{{ $menu->menu_name }}"
                                        data-price="{{ $menu->price }}"
                                    >
                                        <x-lucide-pen class="w-6" />
                                    </x-icon-button>
                                    |
                                    <x-icon-button color='red'
                                        data-open-modal="modalDeleteMenu"
                                        data-type="delete"
                                        data-delete-url="{{ route('menu.destroy', $menu->menu_id) }}"
                                    >
                                        <x-lucide-trash-2 class="w-6" />
                                    </x-icon-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="4">There is no data :(</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <td colspan="4">
                    {{ $menus->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>

    <x-modal id="modalAddMenu" title="Add Menu">
        <form method="POST" id="formAddMenu" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="menuName" class="font-bold text-sm w-fit">Menu Name</label>
                <input type="text" name="menuName" id="menuName" placeholder="Menu Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="menuPrice" class="font-bold text-sm w-fit">Menu Price</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none focus-within:bg-red-main/10 focus-within:border-red-main transition">
                    <div class="pl-2">$</div>
                    <input type="number" name="menuPrice" id="menuPrice" placeholder="Menu Price" autocomplete="off" required
                    class="w-90 p-2 pl-0 text-sm outline-none">
                </div>
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Add</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalMenuDetail" title="Menu Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>Menu ID</p>
            <p>: <span id="modalMenuId"></span></p>
            <p>Menu Name</p>
            <p>: <span id="modalMenuName"></span></p>
            <p>Price /piece</p>
            <p>: <span id="modalPrice"></span></p>
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

    <x-modal id="modalUpdateMenu" title="Update Menu">
        <form method="POST" id="formUpdateMenu" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label for="menuName" class="font-bold text-sm w-fit">Menu Name</label>
                <input type="text" name="menuName" id="modalMenuName" placeholder="Menu Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="menuPrice" class="font-bold text-sm w-fit">Menu Price</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none focus-within:bg-red-main/10 focus-within:border-red-main transition">
                    <div class="pl-2">$</div>
                    <input type="number" name="menuPrice" id="modalPrice" placeholder="Menu Price" autocomplete="off" required
                    class="w-90 p-2 pl-0 text-sm outline-none">
                </div>
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

    <x-modal id="modalDeleteMenu" title="Delete Menu">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this menu?</p>
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

    <x-toast />
</x-layout>