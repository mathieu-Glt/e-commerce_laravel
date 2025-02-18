<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'isMega',
        'parent_id'  // Si vous avez une hiérarchie de catégories
    ];

    // Relation avec les sous-catégories (si hiérarchique)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relation avec la catégorie parente
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Si vous avez une relation avec des produits
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
