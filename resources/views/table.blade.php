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
                        data-open-modal="modalAddTable"
                        data-type="create"
                        data-create-url="{{ route('table.store') }}"
                        data-target-form="formAddTable"
                    >
                        <x-lucide-plus-circle class="w-5" />Add Table
                    </x-secondary-button>
                </div>
            @endif
        </div>
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Table Name</th>
                    <th class="border-b border-r">Table Capacity</th>
                    <th class="border-b border-r" style="width: 30%">Status</th>
                    <th class="border-b" style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $tables->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2 text-center">Table #{{ $table->table_id }}</td>
                        <td class="border border-white p-2 text-center">{{ $table->table_capacity }} Seats</td>
                        <td class="border border-white p-2 text-center">{!! $table->table_status ? "<span class='px-3 py-1 bg-green-500 rounded-md text-white text-sm font-medium'>Available</span>" : "<span class='px-3 py-1 bg-red-500 rounded-md text-white text-sm font-medium'>Occupied</span>" !!}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalTableDetail"
                                    data-type="detail"
                                    data-table-name="{{ $table->table_id }}"
                                    data-table-capacity="{{ $table->table_capacity }}"
                                    data-table-status="{{ $table->table_status ? 'Available ✅' : 'Occupied ❌' }}"
                                    data-created-at="{{ $table->created_at }}"
                                    data-updated-at="{{ $table->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                @if ($role === 'Administrator')
                                    |
                                    <x-icon-button color='yellow'
                                        data-open-modal="modalUpdateTable"
                                        data-type="update"
                                        data-update-url="{{ route('table.update', $table->table_id) }}"
                                        data-target-form="formUpdateTable"
                                        data-table-capacity="{{ $table->table_capacity }}"
                                    >
                                        <x-lucide-pen class="w-6" />
                                    </x-icon-button>
                                    |
                                    <x-icon-button color='red'
                                        data-open-modal="modalDeleteTable"
                                        data-type="delete"
                                        data-delete-url="{{ route('table.destroy', $table->table_id) }}"
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
                    {{ $tables->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>

    <x-modal id="modalAddTable" title="Add Table">
        <form method="POST" id="formAddTable" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="tableCapacity" class="font-bold text-sm w-fit">Table Capacity</label>
                <select name="tableCapacity" id="tableCapacity" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Table Capacity</option>
                    <option value="2" class="bg-white">2 Seats</option>
                    <option value="4" class="bg-white">4 Seats</option>
                    <option value="8" class="bg-white">8 Seats</option>
                </select>
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

    <x-modal id="modalTableDetail" title="Table Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>Table Name</p>
            <p>: Table #<span id="modalTableName"></span></p>
            <p>Table Capacity</p>
            <p>: <span id="modalTableCapacity"></span> Seats</p>
            <p>Table Status</p>
            <p>: <span id="modalTableStatus"></span></p>
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

    <x-modal id="modalUpdateTable" title="Update Table">
        <form method="POST" id="formUpdateTable" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label for="tableCapacity" class="font-bold text-sm w-fit">Table Capacity</label>
                <select name="tableCapacity" id="modalTableCapacity" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Table Capacity</option>
                    <option value="2" class="bg-white">2 Seat</option>
                    <option value="4" class="bg-white">4 Seat</option>
                    <option value="8" class="bg-white">8 Seat</option>
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

    <x-modal id="modalDeleteTable" title="Delete Table">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this table?</p>
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