<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Table;
use App\Models\Customer;
use App\Models\OrderGroup;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();
        Customer::factory()->count(20)->create();
        Table::factory()->count(10)->create();
        Menu::factory()->count(10)->create();

        // Lalu buat order group
        OrderGroup::factory()->count(20)->create();

        // Order dan transaction bisa dibuat setelah order_groups tersedia
        Order::factory()->count(40)->create(); // bisa banyak karena satu group bisa banyak order
        Transaction::factory()->count(20)->create();
    }
}
