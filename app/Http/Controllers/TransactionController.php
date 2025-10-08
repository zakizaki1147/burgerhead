<?php

namespace App\Http\Controllers;

use App\Models\OrderGroup;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['orderGroup.customer'])->paginate(10);
        $totalTransactions = Transaction::count();
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
            $group->total_price = $group->orders->reduce(function ($carry, $order) {
                return $carry + ($order->menu->price * $order->menu_amount);
            }, 0);
            return $group;
        });

        return view('transaction', [
            'title' => 'Transaction',
            'transactions' => $transactions,
            'totalTransactions' => $totalTransactions,
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

        $transaction = Transaction::create([
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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'create',
            'description' => 'Created a new transaction with ID: #' . $transaction->transaction_id . ' for ORD #' . $orderGroup->order_group_id . '-' . $orderGroup->customer_id . '-' . $orderGroup->table_id
        ]);
        
        $table = $orderGroup->table;
        $table->table_status = true;
        $table->save();

        return redirect()->back()->with('success', 'Transaction added successfully!');
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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'update',
            'description' => 'Updated a transaction with ID: #' . $transaction->transaction_id . ' for ORD #' . $transaction->order_group_id . '-' . $transaction->orderGroup->customer_id . '-' . $transaction->orderGroup->table_id
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
        $description = 'Deleted a transaction with ID: #' . $transaction->transaction_id;

        if ($transaction->orderGroup) {
            $description .= ' for ORD #' . $transaction->order_group_id . '-' . $transaction->orderGroup->customer_id . '-' . $transaction->orderGroup->table_id . '.';
        }

        $transaction->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'delete',
            'description' => $description
        ]);

        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully!');
    }

    public function exportExcel()
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'export',
            'description' => 'Exported transaction data to excel.'
        ]);

        return Excel::download(new TransactionExport, 'transactions-burgerhead.xlsx');
    }

    public function printReceipt(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,transaction_id'
        ]);

        $transaction = Transaction::with(['orderGroup.customer', 'orderGroup.table', 'orderGroup.orders.menu'])->findOrFail($request->transaction_id);

        $pdf = FacadePdf::loadView('receipt-pdf.transaction-receipt', ['transaction' => $transaction]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'print',
            'description' => 'Printed receipt for transaction with ID: #' . $transaction->transaction_id
        ]);

        return $pdf->download('transaction-receipt-' . $transaction->transaction_id . '.pdf');
    }
}
