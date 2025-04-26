<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGroup;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'menu',
            'orderGroup.customer',
            'orderGroup.user',
            'orderGroup.table'
        ])->orderBy('order_group_id', 'asc')->get();

        $groupedOrders = $orders->groupBy('order_group_id');

        $customers = Customer::all();

        $availableTables = Table::where('table_status', true)->orderBy('table_id')->get();

        $menus = Menu::all();

        return view('order', [
            'title' => 'Order',
            'groupedOrders' => $groupedOrders,
            'customers' => $customers,
            'availableTables' => $availableTables,
            'menus' => $menus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerId' => 'required|exists:customers,customer_id',
            'tableId' => 'required|exists:tables,table_id',
            'menu' => 'required|array|min:1',
            'menu.*' => 'required|exists:menus,menu_id',
            'amount' => 'required|array|min:1',
            'amount.*' => 'required|integer|min:1'
        ]);

        $orderGroup = OrderGroup::create([
            'customer_id' => $validated['customerId'],
            'table_id' => $validated['tableId'],
            'user_id' => Auth::id(),
            'order_status' => false
        ]);

        foreach ($validated['menu'] as $index => $menuId) {
            Order::create([
                'order_group_id' => $orderGroup->order_group_id,
                'menu_id' => $menuId,
                'menu_amount' => $request->amount[$index]
            ]);
        }

        Table::where('table_id', $validated['tableId'])->update([
            'table_status' => false
        ]);

        return redirect()->route('order.index')->with('success', 'Order added successfully!');
    }

    public function update(Request $request, $orderGroupId)
    {
        $validated = $request->validate([
            'customerId' => 'required|exists:customers,customer_id',
            'tableId' => 'required|exists:tables,table_id',
            'menu' => 'required|array|min:1',
            'menu.*' => 'required|exists:menus,menu_id',
            'amount' => 'required|array|min:1',
            'amount.*' => 'required|integer|min:1',
        ]);

        $orderGroup = OrderGroup::findOrFail($orderGroupId);
        $orderGroup->touch();
        $oldTableId = $orderGroup->table_id;

        $orderGroup->update([
            'customer_id' => $validated['customerId'],
            'table_id' => $validated['tableId'],
            'user_id' => Auth::id()
        ]);

        if ($oldTableId != $validated['tableId']) {
            Table::where('table_id', $oldTableId)->update([
                'table_status' => true
            ]);
        }

        Table::where('table_id', $validated['tableId'])->update([
            'table_status' => false
        ]);

        Order::where('order_group_id', $orderGroupId)->delete();

        foreach($validated['menu'] as $index => $menuId) {
            Order::create([
                'order_group_id' => $orderGroupId,
                'menu_id' => $menuId,
                'menu_amount' => $validated['amount'][$index]
            ]);
        }

        return redirect()->route('order.index')->with('success', 'Order updated successfully!');
    }

    public function destroy($orderGroupId)
    {
        $orderGroup = OrderGroup::with([
            'orders', 'table'
        ])->findOrFail($orderGroupId);

        if ($orderGroup->table) {
            $table = $orderGroup->table;
            $table->table_status = true;
            $table->save();
        }

        $orderGroup->orders()->delete();
        $orderGroup->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully!');
    }
}
