<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $images = [
        'vetements.jpeg',
        'chaussures.jpeg',
        'accessoires.jpeg',
        'electronique.jpeg',
        'mobilier.jpeg',
        'sports.jpeg',
        'beaute.jpeg',
        'livres.jpeg',
        'jouets.jpeg',
        'alimentation.jpeg'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'image' => 'storage/images/categories/' . fake()->randomElement($this->images),
            'isMega' => fake()->boolean(20), // 20% de chance d'être true
            'parent_id' => null, // Vous pouvez modifier ceci pour créer une hiérarchie
        ];
    }
}
