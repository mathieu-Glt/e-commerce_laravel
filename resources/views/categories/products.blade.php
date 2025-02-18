<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Produits de la catégorie : {{ $category->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('categories.show', $category) }}"
                    class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                    Retour aux détails
                </a>
                <a href="{{ route('products.create') }}"
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                    Ajouter un produit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="aspect-w-16 aspect-h-9">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">Aucune image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>

                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-lg font-bold text-gray-900">
                                                {{ number_format($product->price, 2) }} €
                                            </span>
                                            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center mt-4">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                Voir détails
                                            </a>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="text-indigo-600 hover:text-indigo-800">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">
                                Aucun produit dans cette catégorie.
                            </p>
                            <a href="{{ route('products.create') }}"
                                class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Ajouter un produit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>