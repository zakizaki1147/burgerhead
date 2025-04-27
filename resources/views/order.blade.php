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
            <div class="flex justify-center items-center gap-2">
                <div class="w-fit">
                    <form action="{{ route('order.export-excel') }}" method="POST" target="__blank">
                        @csrf
                        <x-primary-button color='yellow-main' type="submit">
                            <x-lucide-download class="w-5" />Export Excel
                        </x-primary-button>
                    </form>
                </div>
                @if ($role === 'Waiter')
                    <div class="w-fit">
                        <x-secondary-button color='red-main'
                        data-open-modal="modalAddOrder"
                        data-type="create"
                        data-create-url="{{ route('order.store') }}"
                        data-target-form="formAddOrder"
                        >
                            <x-lucide-plus-circle class="w-5" />Add Order
                        </x-secondary-button>
                    </div>
                @endif
            </div>
        </div>
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Order Group ID</th>
                    <th class="border-b border-r">Customer Name</th>
                    <th class="border-b border-r">Menu Ordered</th>
                    <th class="border-b border-r">Amount</th>
                    <th class="border-b border-r">Table</th>
                    <th class="border-b border-r">Status</th>
                    <th class="border-b" style="width: 12%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @forelse ($groupedOrders as $groupId => $orders)
                    @php
                        $bgClass = $no % 2 === 0 ? 'bg-white-main' : 'bg-white';
                        $borderClass = $no % 2 === 0 ? 'border-white' : 'border-white-main';
                        $menuList = $orders->map(fn($order) => [
                            'menu_id' => $order->menu_id,
                            'menu_name' => $order->menu->menu_name,
                            'menu_amount' => $order->menu_amount
                        ]);
                    @endphp
                    @foreach ($orders as $index => $order)
                        <tr class="{{ $bgClass }} text-black-main">
                            @if ($index === 0)
                                <td class="border-b-2 border-r-2 {{ $borderClass }} p-2 text-center font-bold" rowspan="{{ $orders->count() }}">{{ $no }}</td>
                                <td class="border-2 {{ $borderClass }} p-2 text-center" rowspan="{{ $orders->count() }}">
                                    ORD#{{ $groupId }}-{{ $order->orderGroup->customer_id }}-{{ $order->orderGroup->table_id }}
                                </td>
                                <td class="border-2 {{ $borderClass }} p-2" rowspan="{{ $orders->count() }}">
                                    {{ $order->orderGroup->customer->customer_name }}
                                </td>
                            @endif
                            <td class="border-2 {{ $borderClass }} p-2">{{ $order->menu->menu_name }}</td>
                            <td class="border-2 {{ $borderClass }} p-2 text-center">{{ $order->menu_amount }}</td>
                            @if ($index === 0)
                                <td class="border-2 {{ $borderClass }} p-2 text-center" rowspan="{{ $orders->count() }}">Table #{{ $order->orderGroup->table->table_id }}</td>
                                <td class="border-2 {{ $borderClass }} p-2 text-center" rowspan="{{ $orders->count() }}">{{ $order->orderGroup->order_status ? 'Already Paid ✅' : 'Not Yet Paid ❌' }}</td>
                                <td class="border-b-2 {{ $borderClass }}" rowspan="{{ $orders->count() }}">
                                    <div class="flex justify-center items-center gap-1">
                                        <x-icon-button color='cyan'
                                            data-open-modal="modalOrderDetail"
                                            data-type="detail"
                                            data-order-group-id="ORD #{{ $groupId }}-{{ $order->orderGroup->customer_id }}-{{ $order->orderGroup->table_id }}"
                                            data-customer-name="{{ $orders[0]->orderGroup->customer->customer_name }}"
                                            data-menu-list="{{ $menuList->toJSON() }}"
                                            data-table-id="Table #{{ $orders[0]->orderGroup->table_id }}"
                                            data-order-status="{{ $orders[0]->orderGroup->order_status ? 'Already Paid ✅' : 'Not Yet Paid ❌' }}"
                                            data-waiter-name="{{ $orders[0]->orderGroup->user->full_name }}"
                                            data-created-at="{{ $orders[0]->orderGroup->created_at }}"
                                            data-updated-at="{{ $orders[0]->orderGroup->updated_at }}"
                                        >
                                            <x-lucide-info class="w-6" />
                                        </x-icon-button>
                                        @if ($role === 'Waiter')
                                            |
                                            <x-icon-button color='yellow'
                                            data-open-modal="modalUpdateOrder"
                                            data-type="update"
                                                data-update-url="{{ route('order.update', $order->order_group_id) }}"
                                                data-target-form="formUpdateOrder"
                                                data-customer-id="{{ $order->orderGroup->customer_id }}"
                                                data-table-id="{{ $order->orderGroup->table->table_id }}"
                                                data-menu-list="{{ $menuList->toJSON() }}"
                                            >
                                                <x-lucide-pen class="w-6" />
                                            </x-icon-button>
                                            |
                                            <x-icon-button color='red'
                                                data-open-modal="modalDeleteOrder"
                                                data-type="delete"
                                                data-delete-url="{{ route('order.destroy', $order->order_group_id) }}"
                                            >
                                                <x-lucide-trash-2 class="w-6" />
                                            </x-icon-button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @php
                        $no++;
                    @endphp
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="9">There is no data :(</td>
                    </tr>
                @endforelse

                {{-- @forelse ($orders as $order)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center">{{ $orders->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2 text-center">ORD#{{ $order->order_group_id }}-{{ $order->orderGroup->customer_id }}-{{ $order->orderGroup->table_id }}</td>
                        <td class="border border-white p-2">{{ $order->orderGroup->customer->customer_name }}</td>
                        <td class="border border-white p-2">{{ $order->menu->menu_name }}</td>
                        <td class="border border-white p-2 text-center">{{ $order->menu_amount }}</td>
                        <td class="border border-white p-2">{{ $order->orderGroup->user->full_name }}</td>
                        <td class="border border-white p-2">Table #{{ $order->orderGroup->table->table_id }}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalOrderDetail"
                                    data-type="detail"
                                    data-order-id="{{ $order->order_id }}"
                                    data-order-group-id="{{ $order->order_group_id }}"
                                    data-customer-name="{{ $order->orderGroup->customer->customer_name }}"
                                    data-menu-name="{{ $order->menu->menu_name }}"
                                    data-menu-amount="{{ $order->menu_amount }}"
                                    data-waiter-name="{{ $order->orderGroup->user->full_name }}"
                                    data-table-name="{{ $order->orderGroup->table_id }}"
                                    data-created-at="{{ $order->created_at }}"
                                    data-updated-at="{{ $order->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                |
                                <x-icon-button color='yellow'
                                    data-open-modal="modalUpdateOrder"
                                    data-type="update"
                                    data-update-url="{{ route('order.update', $order->order_group_id) }}"
                                    data-target-form="formUpdateOrder"
                                    data-customer-id="{{ $order->orderGroup->customer_id }}"
                                    data-menu-name="{{ $order->menu_id }}"
                                    data-menu-amount="{{ $order->menu_amount }}"
                                    data-table-id="{{ $order->orderGroup->table_id }}"
                                >
                                    <x-lucide-pen class="w-6" />
                                </x-icon-button>
                                |
                                <x-icon-button color='red'
                                    data-open-modal="modalDeleteOrder"
                                    data-type="delete"
                                    data-delete-url="{{ route('order.destroy', $order->order_group_id) }}"
                                >
                                    <x-lucide-trash-2 class="w-6" />
                                </x-icon-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="8">There is no data :(</td>
                    </tr>
                @endforelse --}}
            </tbody>
            {{-- <tfoot>
                <td colspan="8">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot> --}}
        </table>
    </div>

    <x-modal id="modalAddOrder" title="Add Order">
        <form method="POST" id="formAddOrder" class="flex flex-col gap-3">
            @csrf
            <div class="flex">
                <div class="flex flex-col gap-3 pr-3 border-r">
                    <div class="flex flex-col">
                        <label for="customerId" class="font-bold text-sm w-fit">Customer Name</label>
                        <select name="customerId" id="customerId" required class="w-70 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                            <option value="" selected disabled class="bg-white">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="tableId" class="font-bold text-sm w-fit">Table Number</label>
                        <select name="tableId" id="tableId" required class="w-70 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                            <option value="" selected disabled class="bg-white">Select Table</option>
                            @foreach ($availableTables as $table)
                                <option value="{{ $table->table_id }}">Table #{{ $table->table_id }} - {{ $table->table_capacity }} Seats</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-3 pl-3 border-l">
                    <div class="menu-list flex flex-col gap-3">
                        <div class="menu-group flex items-center gap-2">
                            <div class="flex flex-col">
                                <label for="menu" class="font-bold text-sm w-fit">Menu</label>
                                <select name="menu[]" id="menu" required class="menu-select w-60 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                                    <option value="" selected disabled class="bg-white">Choose Menu</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->menu_id }}">{{ $menu->menu_name }} - ${{ $menu->price }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="amount" class="font-bold text-sm w-fit">Amount</label>
                                <div class="flex justify-center items-center">
                                    <button type="button" class="decrease-amount-button text-lg px-3 h-10 bg-red-main text-white-main font-bold outline-none rounded-l-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">-</button>
                                    <input type="number" name="amount[]" id="amount" min="1" value="1" required
                                    class="amount-input w-10 h-full py-2 px-1 text-sm text-center border-2 border-black-main outline-none focus:bg-red-main/10 focus:border-red-main transition" />
                                    <button type="button" class="increase-amount-button text-lg px-3 h-10 bg-red-main text-white-main font-bold outline-none rounded-r-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">+</button>
                                </div>
                            </div>
                            <div class="flex justify-end items-end h-full">
                                <x-secondary-button color="red-main" type="button" class="remove-menu-button h-10 hidden">
                                    <x-lucide-minus-circle class="w-5"></x-lucide-minus-circle>Remove
                                </x-secondary-button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 justify-end items-end">
                        <x-secondary-button color="red-main" type="button" class="add-menu-button h-10">
                            <x-lucide-plus-circle class="w-5"></x-lucide-plus-circle>Add Menu
                        </x-secondary-button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center items-end gap-3">
                <hr class="w-full border border-black-main" />
                <div class="w-1/3 flex gap-3">
                    <div class="w-1/2">
                        <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                    </div>
                    <div class="w-1/2">
                        <x-primary-button color='red-main' type="submit">Add</x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalOrderDetail" title="Order Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>Order Group ID</p>
            <p>: <span id="modalOrderGroupId"></span></p>
            <p>Customer Name</p>
            <p>: <span id="modalCustomerName"></span></p>
            <p>Menu List</p>
            <span class="flex gap-5">:
                <ul id="modalMenuList" class="list-decimal"></ul>
            </span>
            <p>Table Name</p>
            <p>: <span id="modalTableId"></span></p>
            <p>Order Status</p>
            <p>: <span id="modalOrderStatus"></span></p>
            <p>Waiter Name</p>
            <p>: <span id="modalWaiterName"></span></p>
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

    <x-modal id="modalUpdateOrder" title="Update Order">
        <form method="POST" id="formUpdateOrder" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex">
                <div class="flex flex-col gap-3 pr-3 border-r">
                    <div class="flex flex-col">
                        <label for="customerId" class="font-bold text-sm w-fit">Customer Name</label>
                        <select name="customerId" id="modalCustomerId" required class="w-70 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                            <option value="" selected disabled class="bg-white">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="tableId" class="font-bold text-sm w-fit">Table Number</label>
                        <select name="tableId" id="modalTableId" required class="w-70 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                            <option value="" selected disabled class="bg-white">Select Table</option>
                            @foreach ($availableTables as $table)
                                <option value="{{ $table->table_id }}">Table #{{ $table->table_id }} - {{ $table->table_capacity }} Seats</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-3 pl-3 border-l">
                    <div class="menu-list flex flex-col gap-3">
                        <div class="menu-group flex items-center gap-2">
                            <div class="flex flex-col">
                                <label for="menu" class="font-bold text-sm w-fit">Menu</label>
                                <select name="menu[]" required class="menu-select w-60 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                                    <option value="" selected disabled class="bg-white">Choose Menu</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->menu_id }}">{{ $menu->menu_name }} - ${{ $menu->price }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="amount" class="font-bold text-sm w-fit">Amount</label>
                                <div class="flex justify-center items-center">
                                    <button type="button" class="decrease-amount-button text-lg px-3 h-10 bg-red-main text-white-main font-bold outline-none rounded-l-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">-</button>
                                    <input type="number" name="amount[]" min="1" value="1" required
                                    class="amount-input w-10 h-full py-2 px-1 text-sm text-center border-2 border-black-main outline-none focus:bg-red-main/10 focus:border-red-main transition" />
                                    <button type="button" class="increase-amount-button text-lg px-3 h-10 bg-red-main text-white-main font-bold outline-none rounded-r-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">+</button>
                                </div>
                            </div>
                            <div class="flex justify-end items-end h-full">
                                <x-secondary-button color="red-main" type="button" class="remove-menu-button h-10 hidden">
                                    <x-lucide-minus-circle class="w-5"></x-lucide-minus-circle>Remove
                                </x-secondary-button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 justify-end items-end">
                        <x-secondary-button color="red-main" type="button" class="add-menu-button h-10">
                            <x-lucide-plus-circle class="w-5"></x-lucide-plus-circle>Add Menu
                        </x-secondary-button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center items-end gap-3">
                <hr class="w-full border border-black-main" />
                <div class="w-1/3 flex gap-3">
                    <div class="w-1/2">
                        <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                    </div>
                    <div class="w-1/2">
                        <x-primary-button color='red-main' type="submit">Update</x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalDeleteOrder" title="Delete Order">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this order?</p>
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

    @if (session('success') || $errors->any())
        <div id="alert" class="fixed bottom-4 right-4 z-10 transition-opacity duration-700">
            <div class="p-4 font-semibold rounded-md flex justify-center items-center {{ session('success') ? 'bg-green-500' : 'bg-red-500 text-white-main' }}">
                @if (session('success'))
                    <x-lucide-circle-check class="w-10 mr-1" />| {{ session('success') }}
                @else
                    <x-lucide-circle-x class="w-10 mr-1" />| {{ $errors->first() }}
                @endif
            </div>
        </div>

        <script>
            const alert = document.getElementById('alert');

            if (alert) {
                setTimeout(() => {
                    alert.classList.add('opacity-0');
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 700)
                }, 3000);
            }
        </script>
    @endif
</x-layout>