<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
            "user_id"           => 1,
            "title"             => fake()->unique()->word(5),
            "sku"               => fake()->unique()->numberBetween(1, 9999),
            "short_description" => fake()->paragraph(10),
            "description"       => fake()->paragraph(15),
            "add_info"          => fake()->paragraph(10),
            "price"             => fake()->numberBetween(1, 9999),
            "sale_price"        => fake()->numberBetween(1, 9999),
            "image"             => "product.jpg",
        ];
    }
}
