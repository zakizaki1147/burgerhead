<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\OrderGroup;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalMenus = Menu::count();
        $totalOrderGroups = OrderGroup::count();
        $totalTables = Table::count();
        $totalTransactions = Transaction::count();
        $totalUsers = User::count();

        $unpaidOrders = OrderGroup::where('order_status', false)->get();

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalCustomers' => $totalCustomers,
            'totalMenus' => $totalMenus,
            'totalOrderGroups' => $totalOrderGroups,
            'totalTables' => $totalTables,
            'totalTransactions' => $totalTransactions,
            'totalUsers' => $totalUsers,

            'unpaidOrders' => $unpaidOrders
        ]);
    }
}
