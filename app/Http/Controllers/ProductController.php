<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $query = Product::with('category');

        // Log avant les filtres
        Log::debug('Initial Query:', [
            'query_builder' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            Log::debug('After Category Filter:', [
                'category_id' => $request->category,
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
        }

        // Filtre par disponibilité
        if ($request->filled('availability')) {
            $query->where('isAvailable', $request->availability);
        }

        // Filtre par recherche
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
            Log::debug('After Search Filter:', [
                'search' => $request->search,
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
        }

        // Tri
        switch ($request->sort ?? 'newest') {
            case 'price_asc':
                $query->orderByRaw('COALESCE(soldePrice, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(soldePrice, price) DESC');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $products->appends($request->query());

        // Log final avec toutes les informations
        Log::debug('Final Query Details:', [
            'executed_queries' => DB::getQueryLog(),
            'request_params' => $request->all(),
            'url' => $request->fullUrl(),
            'total_products' => $products->total(),
            'current_page' => $products->currentPage(),
            'per_page' => $products->perPage()
        ]);

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'more_description' => 'nullable|string',
            'text' => 'nullable|string',
            'soldePrice' => 'nullable|numeric|min:0',
            'regularPrice' => 'nullable|numeric|min:0',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'material' => 'nullable|string',
            'brand' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isAvailable' => 'boolean',
            'isNewArrival' => 'boolean',
            'isBestSeller' => 'boolean',
            'isFeatured' => 'boolean',
            'isSpecialOffer' => 'boolean',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/products');
            $validated['image'] = str_replace('public/', 'storage/', $imagePath);
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['isActive'] = true;

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produit créé avec succès');
    }

    /**
     * Afficher un produit spécifique
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'more_description' => 'nullable|string',
            'text' => 'nullable|string',
            'soldePrice' => 'nullable|numeric|min:0',
            'regularPrice' => 'nullable|numeric|min:0',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'material' => 'nullable|string',
            'brand' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isAvailable' => 'boolean',
            'isNewArrival' => 'boolean',
            'isBestSeller' => 'boolean',
            'isFeatured' => 'boolean',
            'isSpecialOffer' => 'boolean',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }

            $imagePath = $request->file('image')->store('public/images/products');
            $validated['image'] = str_replace('public/', 'storage/', $imagePath);
        }

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete(str_replace('storage/', 'public/', $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produit supprimé avec succès');
    }

    /**
     * Toggle la disponibilité d'un produit
     */
    public function toggleAvailability(Product $product)
    {
        $product->update([
            'isAvailable' => !$product->isAvailable
        ]);

        return back()->with('success', 'Disponibilité mise à jour');
    }

    /**
     * Show products on sale.
     */
    public function onSale()
    {
        $products = Product::with('category')
            ->whereNotNull('soldePrice')
            ->where('soldePrice', '>', 0)
            ->latest()
            ->paginate(12);

        return view('products.sale', compact('products'));
    }

    /**
     * Show new arrivals.
     */
    public function newArrivals()
    {
        $products = Product::with('category')
            ->where('isNewArrival', true)
            ->latest()
            ->paginate(12);

        return view('products.new-arrivals', compact('products'));
    }

    /**
     * Show best sellers.
     */
    public function bestSellers()
    {
        $products = Product::with('category')
            ->where('isBestSeller', true)
            ->latest()
            ->paginate(12);

        return view('products.best-sellers', compact('products'));
    }
}
