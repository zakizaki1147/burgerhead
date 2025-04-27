<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Excel</title>
    <link rel="shortcut icon" href="/images/burgerhead-logo.png" type="image/x-icon">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order Group ID</th>
                <th>Customer Name</th>
                <th>Menu Ordered</th>
                <th>Amount</th>
                <th>Table</th>
                <th>Status</th>
                <th>Waiter Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($groupedOrders as $groupId => $orders)
                @php
                    $menuList = $orders->map(fn($order) => [
                        'menu_id' => $order->menu_id,
                        'menu_name' => $order->menu->menu_name,
                        'menu_amount' => $order->menu_amount
                    ]);
                @endphp
                @foreach ($orders as $index => $order)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $orders->count() }}">{{ $no }}</td>
                            <td rowspan="{{ $orders->count() }}">
                                ORD#{{ $groupId }}-{{ $order->orderGroup->customer_id }}-{{ $order->orderGroup->table_id }}
                            </td>
                            <td rowspan="{{ $orders->count() }}">
                                {{ $order->orderGroup->customer->customer_name }}
                            </td>
                        @endif
                        <td>{{ $order->menu->menu_name }}</td>
                        <td >{{ $order->menu_amount }}</td>
                        @if ($index === 0)
                            <td rowspan="{{ $orders->count() }}">Table #{{ $order->orderGroup->table->table_id }}</td>
                            <td rowspan="{{ $orders->count() }}">{{ $order->orderGroup->order_status ? 'Already Paid ✅' : 'Not Yet Paid ❌' }}</td>
                            <td rowspan="{{ $orders->count() }}">{{ $order->orderGroup->user->full_name }}</td>
                            <td rowspan="{{ $orders->count() }}">{{ $order->orderGroup->created_at }}</td>
                            <td rowspan="{{ $orders->count() }}">{{ $order->orderGroup->updated_at }}</td>
                        @endif
                    </tr>
                @endforeach
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>