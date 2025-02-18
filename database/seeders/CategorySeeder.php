<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Liste de catégories prédéfinies
        $categories = [
            'Vêtements',
            'Chaussures',
            'Accessoires',
            'Électronique',
            'Mobilier',
            'Sport',
            'Beauté',
            'Livres',
            'Jouets',
            'Alimentation'
        ];

        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category,
                'slug' => Str::slug($category),
                'parent_id' => null,
                'isMega' => false,
            ]);
        }
    }
}
