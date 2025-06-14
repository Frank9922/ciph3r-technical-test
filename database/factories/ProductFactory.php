<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'currency_id' => Currency::factory(),
            'tax_cost' => $this->faker->randomFloat(2, 0, 20),
            'manufacturing_cost' => $this->faker->randomFloat(2, 0, 50),
        ];
    }
}
