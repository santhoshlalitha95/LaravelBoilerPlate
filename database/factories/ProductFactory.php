<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'stock_no' => $this->faker->unique()->numberBetween(100000, 999999),
            'var' => $this->faker->numberBetween(100000, 999999),
            'amount' => $amount = $this->faker->numberBetween(1000, 5000),
            'mrp_amount' => $this->faker->numberBetween($amount + 1, $amount + 500),
            'product_description' => $this->faker->paragraph(),
            'category' => $this->faker->word(),
            'sub_category' => $this->faker->word(),
            'material_type' => $this->faker->word(),
            'finish' => $this->faker->word(),
            'tool_size' => $this->faker->word(),
            'minimum_order_quantity' => $this->faker->numberBetween(100, 500),
        ];
    }
}
