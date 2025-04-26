<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()?->customer_id ?? Customer::factory(),
            'table_id' => Table::inRandomOrder()->first()?->table_id ?? Table::factory(),
            'user_id' => User::inRandomOrder()->first()?->user_id ?? User::factory(),
            'order_status' => false
        ];
    }
}
