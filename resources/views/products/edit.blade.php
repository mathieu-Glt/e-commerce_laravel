<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Modifier le produit') }} : {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informations de base -->
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                    <input type="text" name="name" id="name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required value="{{ old('name', $product->name) }}">
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description courte</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div>
                                    <label for="more_description" class="block text-sm font-medium text-gray-700">Description détaillée</label>
                                    <textarea name="more_description" id="more_description" rows="5"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('more_description', $product->more_description) }}</textarea>
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                                    <select name="category_id" id="category_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Prix et stock -->
                            <div class="space-y-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                                    <input type="number" name="price" id="price" step="0.01" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required value="{{ old('price', $product->price) }}">
                                </div>

                                <div>
                                    <label for="regularPrice" class="block text-sm font-medium text-gray-700">Prix régulier</label>
                                    <input type="number" name="regularPrice" id="regularPrice" step="0.01" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        value="{{ old('regularPrice', $product->regularPrice) }}">
                                </div>

                                <div>
                                    <label for="soldePrice" class="block text-sm font-medium text-gray-700">Prix soldé</label>
                                    <input type="number" name="soldePrice" id="soldePrice" step="0.01" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        value="{{ old('soldePrice', $product->soldePrice) }}">
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                    <input type="number" name="stock" id="stock" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required value="{{ old('stock', $product->stock) }}">
                                </div>

                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantité minimale</label>
                                    <input type="number" name="quantity" id="quantity" min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required value="{{ old('quantity', $product->quantity) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Caractéristiques du produit -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">Couleur</label>
                                <input type="text" name="color" id="color"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('color', $product->color) }}">
                            </div>

                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700">Taille</label>
                                <input type="text" name="size" id="size"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('size', $product->size) }}">
                            </div>

                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700">Poids</label>
                                <input type="text" name="weight" id="weight"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('weight', $product->weight) }}">
                            </div>

                            <div>
                                <label for="dimensions" class="block text-sm font-medium text-gray-700">Dimensions</label>
                                <input type="text" name="dimensions" id="dimensions"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('dimensions', $product->dimensions) }}">
                            </div>

                            <div>
                                <label for="material" class="block text-sm font-medium text-gray-700">Matériau</label>
                                <input type="text" name="material" id="material"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('material', $product->material) }}">
                            </div>

                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700">Marque</label>
                                <input type="text" name="brand" id="brand"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ old('brand', $product->brand) }}">
                            </div>
                        </div>

                        <!-- Options du produit -->
                        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="isAvailable" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('isAvailable', $product->isAvailable) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Disponible</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="checkbox" name="isNewArrival" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('isNewArrival', $product->isNewArrival) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Nouvelle arrivée</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="checkbox" name="isBestSeller" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('isBestSeller', $product->isBestSeller) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Meilleure vente</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="checkbox" name="isFeatured" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('isFeatured', $product->isFeatured) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Mis en avant</span>
                            </label>
                        </div>

                        <!-- Image actuelle et nouvelle image -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Image actuelle</label>
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="w-32 h-32 object-cover rounded">
                                </div>
                            @else
                                <p class="mt-2 text-sm text-gray-500">Aucune image</p>
                            @endif

                            <label for="image" class="block text-sm font-medium text-gray-700 mt-4">Nouvelle image</label>
                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full" accept="image/*">
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 