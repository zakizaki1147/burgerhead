<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\OrderGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'menu_id' => Menu::inRandomOrder()->first()?->menu_id ?? Menu::factory(),
            'menu_amount' => fake()->numberBetween(1, 5)
        ];
    }
}
