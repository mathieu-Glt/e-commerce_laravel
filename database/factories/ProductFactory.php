<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $images = [
        'product1.jpeg',
        'product2.jpeg',
        'product3.jpeg',
        'product4.jpeg',
        'product5.jpeg',
        'product6.jpeg',
        'product7.jpeg',
        'product8.jpeg',
        'product9.jpeg',
        'product10.jpeg'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'more_description' => fake()->paragraphs(3, true),
            'text' => fake()->text(),
            'soldePrice' => fake()->randomFloat(2, 10, 100),
            'regularPrice' => fake()->randomFloat(2, 100, 200),
            'color' => fake()->randomElement(['Rouge', 'Bleu', 'Vert', 'Noir', 'Blanc']),
            'size' => fake()->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'weight' => fake()->randomFloat(2, 0.1, 5) . ' kg',
            'dimensions' => fake()->numberBetween(10, 100) . 'x' . fake()->numberBetween(10, 100) . 'x' . fake()->numberBetween(10, 100),
            'material' => fake()->randomElement(['Coton', 'Polyester', 'Cuir', 'Bois', 'Métal']),
            'brand' => fake()->company(),
            'image' => 'storage/images/products/' . fake()->randomElement($this->images),
            'isAvailable' => fake()->boolean(80),
            'isNewArrival' => fake()->boolean(20),
            'isBestSeller' => fake()->boolean(20),
            'isFeatured' => fake()->boolean(20),
            'isSpecialOffer' => fake()->boolean(20),
            'stock' => fake()->numberBetween(0, 100),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(1, 50),
            'isActive' => true,
            'category_id' => Category::inRandomOrder()->first()->id
        ];
    }
}
