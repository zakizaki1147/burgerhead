<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_group_id' => OrderGroup::inRandomOrder()->first()?->order_group_id ?? OrderGroup::factory(),
            'total_price' => fake()->randomNumber(8, true),
            'pay_amount' => fake()->randomNumber(8, true),
            'change_amount' => fake()->randomNumber(8, true),
            'transaction_status' => false,
            'user_id' => User::inRandomOrder()->first()?->user_id ?? User::factory()
        ];
    }
}
