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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'Burhan Gerald Hedonic',
            'username' => 'owner',
            'password' => Hash::make('password'),
            'role' => 'Owner'
        ]);

        User::create([
            'full_name' => 'Sutejo Strator',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'Administrator'
        ]);

        User::create([
            'full_name' => 'Nasir Aldiano',
            'username' => 'cashier',
            'password' => Hash::make('password'),
            'role' => 'Cashier'
        ]);

        User::create([
            'full_name' => 'Wawa Terhaha',
            'username' => 'waiter',
            'password' => Hash::make('password'),
            'role' => 'Waiter'
        ]);

        Customer::create([
            'customer_name' => 'Dzulqarnaen',
            'gender' => 1,
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->city()
        ]);

        Customer::create([
            'customer_name' => 'Rohan Dermawan',
            'gender' => 1,
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->city()
        ]);

        Customer::create([
            'customer_name' => 'Alif Shidqi',
            'gender' => 1,
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->city()
        ]);

        Customer::create([
            'customer_name' => 'Nanda Ningtyas',
            'gender' => 0,
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->city()
        ]);

        Customer::create([
            'customer_name' => 'Felinus Crisha',
            'gender' => 0,
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->city()
        ]);

        Menu::create([
            'menu_name' => 'Beef Burger',
            'price' => 1,
        ]);

        Menu::create([
            'menu_name' => 'BLACK Burger',
            'price' => 1.5,
        ]);

        Menu::create([
            'menu_name' => 'Cheese Burger',
            'price' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Crispy Chicken Burger',
            'price' => 1.5,
        ]);

        Menu::create([
            'menu_name' => 'Double Cheese Burger',
            'price' => 1.5,
        ]);

        Menu::create([
            'menu_name' => 'Fish Burger',
            'price' => 1.5,
        ]);

        Menu::create([
            'menu_name' => 'French Fries',
            'price' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Chicken Nugget',
            'price' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Ice Tea',
            'price' => 0.6,
        ]);

        Menu::create([
            'menu_name' => 'Lemon Tea',
            'price' => 0.6,
        ]);

        Table::factory()->count(10)->create();
    }
}
