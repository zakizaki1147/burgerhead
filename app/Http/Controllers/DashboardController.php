<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGroup;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $unpaidOrderGroups = OrderGroup::with(['customer', 'table', 'orders.menu'])
            ->where('order_status', false)
            ->get()
            ->map(function ($group) {
                $group->total_price = $group->orders->reduce(function ($carry, $order) {
                    return $carry + ($order->menu->price * $order->menu_amount);
                }, 0);
                return $group;
            });

        $availableTablesChart = Table::where('table_status', true)->count();
        $occupiedTablesChart = Table::where('table_status', false)->count();

        $unpaidOrderGroupsChart = OrderGroup::where('order_status', false)->count();
        $paidOrderGroupsChart = OrderGroup::where('order_status', true)->count();

        $startDate = Carbon::now()->subDays(6)->startOfDay();

        $revenue = Transaction::query()
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->where('transaction_status', true)
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = collect();
        for ($i=6; $i >= 0; $i--) { 
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $revenueLabelsChart = $dates->map(fn($date) => Carbon::parse($date)->translatedFormat('D, d M'));
        $revenueDataChart = $dates->map(function ($date) use ($revenue) {
            return $revenue->firstWhere('date', $date)->total ?? 0;
        });

        $topMenus = Order::with('menu')
            ->selectRaw('menu_id, SUM(menu_amount) as total_ordered')
            ->groupBy('menu_id')
            ->orderByDesc('total_ordered')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'menu_name' => $order->menu->menu_name ?? 'Unknown',
                    'total_ordered' => $order->total_ordered,
                ];
            });

        $topMenusLabelsChart = $topMenus->pluck('menu_name');
        $topMenusDataChart = $topMenus->pluck('total_ordered');

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalCustomers' => $totalCustomers,
            'totalMenus' => $totalMenus,
            'totalOrderGroups' => $totalOrderGroups,
            'totalTables' => $totalTables,
            'totalTransactions' => $totalTransactions,
            'totalUsers' => $totalUsers,
            'unpaidOrderGroups' => $unpaidOrderGroups,
            'availableTablesChart' => $availableTablesChart,
            'occupiedTablesChart' => $occupiedTablesChart,
            'unpaidOrderGroupsChart' => $unpaidOrderGroupsChart,
            'paidOrderGroupsChart' => $paidOrderGroupsChart,
            'revenueLabelsChart' => $revenueLabelsChart,
            'revenueDataChart' => $revenueDataChart,
            'topMenusLabelsChart' => $topMenusLabelsChart,
            'topMenusDataChart' => $topMenusDataChart,
        ]);
    }
}
