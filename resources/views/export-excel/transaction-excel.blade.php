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
                <th>Total Price</th>
                <th>Pay Amount</th>
                <th>Change Amount</th>
                <th>Status</th>
                <th>Cashier Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $no }}</td>
                    <td>ORD #{{ $transaction->order_group_id }}-{{ $transaction->orderGroup->customer_id }}-{{ $transaction->orderGroup->table_id }}</td>
                    <td>${{ $transaction->total_price }}</td>
                    <td>${{ $transaction->pay_amount }}</td>
                    <td>${{ $transaction->change_amount }}</td>
                    <td>{{ $transaction->transaction_status ? 'Success ✅' : 'Pending ❌' }}</td>
                    <td>{{ $transaction->orderGroup->user->full_name }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->updated_at }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>