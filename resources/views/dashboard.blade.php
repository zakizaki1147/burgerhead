<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
        <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Data Summary</h1>
        <hr class="w-full border border-black-main" />
        <div class="grid grid-cols-4 gap-2">
            @php
                $role = Auth::user()->role;
            @endphp
            @if ($role === 'Administrator')
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-layers-2 class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Table</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTables }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-user-pen class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total User</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalUsers }}</h3>
                </div>
            @elseif ($role === 'Waiter')
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
            @elseif ($role === 'Cashier')
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-dollar-sign class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Transaction</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTransactions }}</h3>
                </div>
            @elseif ($role === 'Owner')
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-layers-2 class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Table</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTables }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-dollar-sign class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Transaction</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTransactions }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total User</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalUsers }}</h3>
                </div>
            @endif



            {{-- <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                <h3 class="font-bold text-red-main text-4xl">50</h3>
            </div>
            <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                <h3 class="font-bold text-red-main text-4xl">50</h3>
            </div>
            <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                <x-lucide-layers-2 class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                <h3 class="max-w-24 font-bold text-red-main text-center">Total Table</h3>
                <h3 class="font-bold text-red-main text-4xl">50</h3>
            </div>
            <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                <x-lucide-user-pen class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                <h3 class="max-w-24 font-bold text-red-main text-center">Total User</h3>
                <h3 class="font-bold text-red-main text-4xl">50</h3>
            </div> --}}
        </div>
    </div>
    {{-- @if ($role === 'Cashier')
        <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Recent Order(s)</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-3 gap-2">
                @forelse ($unpaidOrders as $unpaidOrder)
                    <div class="w-full border-2 flex flex-col border-red-main rounded-lg">
                        <div class="w-full bg-red-main">
                            <h1 class="p-2 text-white text-lg text-center font-bold">Table #{{ $unpaidOrder->table_id }}</h1>
                        </div>
                        <div class="p-3.5 flex-1 flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h2 class="font-bold text-lg">ORD #{{ $unpaidOrder->order_group_id }}-{{ $unpaidOrder->customer_id }}-{{ $unpaidOrder->table_id }}</h2>
                                    <h3 class="text-gray-500 text-sm">{{ $unpaidOrder->created_at }}</h3>
                                </div>
                                <h3 class="w-fit px-3 py-1 bg-red-500 rounded-md text-white text-sm font-medium">Not Yet Paid</h3>
                            </div>
                            <hr class="w-full border border-black-main" />
                            <ul class="flex flex-1 flex-col">
                                <li class="flex justify-between items-center font-medium">
                                    <p>1. <span class="font-semibold">Cheese Burger</span> - 2pc(s)</p>
                                    <p class="font-semibold">| $6</p>
                                </li>
                                <li class="flex justify-between items-center font-medium">
                                    <p>2. <span class="font-semibold">Fried Chicken</span> - 1pc(s)</p>
                                    <p class="font-semibold">| $4</p>
                                </li>
                            </ul>
                            <hr class="w-full border border-black-main" />
                            <div class="w-full flex justify-between items-center">
                                <div class="w-2/3">
                                    <h3 class="text-gray-500 text-sm">Total:</h3>
                                    <h2 class="font-bold text-lg">$10</h2>
                                </div>
                                <div class="w-1/3">
                                    <x-primary-button color='red-main'>Pay</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    
                @endforelse
            </div>
        </div>
    @endif --}}
</x-layout>