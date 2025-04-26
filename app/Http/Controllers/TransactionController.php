<?php

namespace App\Http\Controllers;

use App\Models\OrderGroup;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['orderGroup.customer'])->paginate(10);

        $unpaidOrderGroups = OrderGroup::with(['customer', 'table'])->where('order_status', false)->get();

        $transactionOrderGroups = collect();

        foreach ($transactions as $transaction) {
            $group = OrderGroup::with(['customer', 'table'])->find($transaction->order_group_id);
            if ($group) {
                $transactionOrderGroups->push($group);
            }
        }

        // $usedOrderGroups = OrderGroup::with(['customer', 'table'])->whereIn('order_group_id', $transactions->pluck('order_group_id'))->get();

        $allOrderGroups = $unpaidOrderGroups->merge($transactionOrderGroups)->unique('order_group_id');

        $allOrderGroups->map(function ($group) {
            $group->total_price = $group->orders->sum(function ($order) {
                return $order->menu->price * $order->menu_amount;
            });
            return $group;
        });

        return view('transaction', [
            'title' => 'Transaction',
            'transactions' => $transactions,
            'unpaidOrderGroups' => $unpaidOrderGroups,
            'unpaidOrderGroupsJson' => $unpaidOrderGroups,
            'allOrderGroups' => $allOrderGroups
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'orderGroupId' => 'required|exists:order_groups,order_group_id',
            'totalPrice' => 'required|numeric|min:0',
            'payAmount' => 'required|numeric',
            'changeAmount' => 'required|numeric|min:0'
        ]);

        if ($validated['payAmount'] < $validated['totalPrice']) {
            return back()->withErrors(['payAmount' => 'Error']);
        }

        Transaction::create([
            'order_group_id' => $validated['orderGroupId'],
            'total_price' => $validated['totalPrice'],
            'pay_amount' => $validated['payAmount'],
            'change_amount' => $validated['changeAmount'],
            'transaction_status' => true,
            'user_id' => Auth::id()
        ]);

        $orderGroup = OrderGroup::find($validated['orderGroupId']);
        $orderGroup->order_status = true;
        $orderGroup->save();

        $table = $orderGroup->table;
        $table->table_status = true;
        $table->save();

        return redirect()->route('transaction.index')->with('success', 'Transaction added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'payAmount' => 'required|numeric|min:0'
        ]);

        $transaction = Transaction::findOrFail($id);

        $changeAmount = $validated['payAmount'] - $transaction->total_price;

        if ($changeAmount < 0) {
            return back()->withErrors('error', 'Ayam');
        }

        $transaction->update([
            'pay_amount' => $validated['payAmount'],
            'change_amount' => $changeAmount,
            'transaction_status' => true
        ]);

        if ($transaction->orderGroup && $transaction->orderGroup->table_id) {
            $transaction->orderGroup->table->update([
                'table_status' => true
            ]);
        }

        if ($transaction->orderGroup) {
            $transaction->orderGroup->update([
                'order_status' => true,
            ]);
        }

        return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully!');
    }
}
