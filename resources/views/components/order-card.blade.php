@props(['unpaidOrder'])

@php
    $totalPrice = 0;
@endphp

<div class="w-full border-2 flex flex-col border-red-main rounded-lg">
    <div class="w-full bg-red-main">
        <h1 class="p-2 text-white text-lg text-center font-bold">Table #{{ $unpaidOrder->table_id }} - {{ $unpaidOrder->customer->customer_name }}</h1>
    </div>
    <div class="p-3.5 flex-1 flex flex-col gap-2">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg">ORD #{{ $unpaidOrder->order_group_id }}-{{ $unpaidOrder->customer_id }}-{{ $unpaidOrder->table_id }}</h2>
                <h3 class="text-gray-500 text-sm">{{ $unpaidOrder->created_at }}</h3>
            </div>
            <h3 class="border border-white text-white text-sm text-center font-medium">{!! $unpaidOrder->order_status ? "<span class='px-3 py-1 bg-green-500 rounded-md'>Already Paid</span>" : "<span class='px-3 py-1 bg-red-500 rounded-md'>Not Yet Paid</span>" !!}</h3>
        </div>
        <hr class="w-full border border-black-main" />
        <ul class="flex flex-1 flex-col">
            @foreach ($unpaidOrder->orders as $index => $order)
                @php
                    $menuName = $order->menu->menu_name ?? 'Unknown';
                    $amount = $order->menu_amount;
                    $price = $order->menu->price ?? 0;
                    $subtotal = $price * $amount;
                    $totalPrice += $subtotal;
                @endphp
                <li class="flex justify-between items-center font-medium">
                    <p>{{ $index + 1}}. <span class="font-semibold">{{ $menuName }}</span> - {{ $amount }}pc(s)</p>
                    <p class="font-semibold">| ${{ $subtotal }}</p>
                </li>
            @endforeach
        </ul>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex justify-between items-center">
            <div class="w-2/3 flex gap-1 items-center">
                <h3 class="text-gray-500">Total:</h3>
                <h2 class="font-bold text-lg">${{ $totalPrice }}</h2>
            </div>
            <div class="w-1/3">
                <x-primary-button color='red-main'>Pay</x-primary-button>
            </div>
        </div>
    </div>
</div>