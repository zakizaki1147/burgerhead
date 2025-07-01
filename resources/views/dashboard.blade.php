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
    @if ($role === 'Cashier')
        <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Recent Order(s)</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-3 gap-2">
                @foreach ($unpaidOrders as $unpaidOrder)
                    <x-order-card :unpaidOrder="$unpaidOrder" />
                @endforeach
            </div>
        </div>
    @endif

    <x-toast />
</x-layout>