<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isMega' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/categories');
            $validated['image'] = str_replace('public/', 'storage/', $imagePath);
        }

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Afficher une catégorie spécifique
     */
    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isMega' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($category->image) {
                Storage::delete(str_replace('storage/', 'public/', $category->image));
            }

            $imagePath = $request->file('image')->store('public/images/categories');
            $validated['image'] = str_replace('public/', 'storage/', $imagePath);
        }

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Category $category)
    {
        // Supprimer l'image si elle existe
        if ($category->image) {
            Storage::delete(str_replace('storage/', 'public/', $category->image));
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès');
    }

    /**
     * Obtenir les produits d'une catégorie
     */
    public function products(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('categories.products', compact('category', 'products'));
    }

    /**
     * Toggle le statut isMega
     */
    public function toggleMega(Category $category)
    {
        $category->update([
            'isMega' => !$category->isMega
        ]);

        return back()->with('success', 'Statut Mega mis à jour');
    }
}
