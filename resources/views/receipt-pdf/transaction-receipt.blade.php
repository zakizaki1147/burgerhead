<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: monospace;
        }
        header {
            text-align: center;
        }
        h2 {
            font-family: sans-serif;
        }
        table {
            width: 100%;
        }
        footer {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>    
        <img src="{{ public_path('images/burgerhead-logo.png') }}" alt="logo" width="100">
        <h2><strong>BURGERHEAD RECEIPT</strong></h2>
    </header>
    <main>
        <p>-------------------------------------------------------------------------</p>
        <table>
            <tr>
                <td><strong>Transaction ID</strong></td>
                <td align="right">{{ $transaction->transaction_id }}</td>
            </tr>
            <tr>
                <td><strong>Order Group ID</strong></td>
                <td align="right">ORD #{{ $transaction->order_group_id }}-{{ $transaction->orderGroup->customer_id }}-{{ $transaction->orderGroup->table_id }}</td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td align="right">{{ $transaction->created_at->format('H:i d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Cashier Name</strong></td>
                <td align="right">{{ $transaction->orderGroup->user->full_name }}</td>
            </tr>
            <tr>
                <td><strong>Customer Name</strong></td>
                <td align="right">{{ $transaction->orderGroup->customer->customer_name }}</td>
            </tr>
            <tr>
                <td><strong>Table</strong></td>
                <td align="right">Table #{{ $transaction->orderGroup->table_id }}</td>
            </tr>
        </table>
        <p>-------------------------------------------------------------------------</p>
        <table>
            @foreach ($transaction->orderGroup->orders as $order)
                <tr>
                    <td><strong>{{ $order->menu->menu_name }}</strong></td>
                    <td align="right">{{ $order->menu_amount }}</td>
                    <td align="right">{{ number_format($order->menu->price, 2) }}</td>
                    <td align="right">{{ number_format($order->menu->price * $order->menu_amount, 2) }}</td>
                </tr>
            @endforeach
        </table>
        <p>-------------------------------------------------------------------------</p>
        <table>
            <tr>
                <td><strong>Total Price</strong></td>
                <td align="right"><strong>{{ number_format($transaction->total_price, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Pay Amount</strong></td>
                <td align="right">{{ number_format($transaction->pay_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Change Amount</strong></td>
                <td align="right">{{ number_format($transaction->change_amount, 2) }}</td>
            </tr>
        </table>
        <p>-------------------------------------------------------------------------</p>
    </main>
    <footer>
        <p>Thanks for purchasing!</p>
        <p>We hope you enjoy it :)</p>
        <p>Please come again if you like it!</p>
    </footer>
</body>
</html>