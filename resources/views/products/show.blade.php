<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Détails du produit') }} : {{ $product->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                    Retour à la liste
                </a>
                <a href="{{ route('products.edit', $product) }}"
                    class="px-4 py-2 text-white bg-indigo-500 rounded hover:bg-indigo-600">
                    Modifier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image du produit -->
                        <div>
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-96 object-cover rounded-lg shadow">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">Aucune image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informations principales -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    Catégorie: <a href="{{ route('categories.show', $product->category) }}"
                                        class="text-indigo-600 hover:text-indigo-800">
                                        {{ $product->category->name }}
                                    </a>
                                </p>
                            </div>

                            <!-- Prix -->
                            <div class="flex items-baseline space-x-4">
                                @if($product->soldePrice)
                                    <p class="text-3xl font-bold text-red-600">
                                        {{ number_format($product->soldePrice, 2) }} €
                                    </p>
                                    <p class="text-xl line-through text-gray-500">
                                        {{ number_format($product->regularPrice, 2) }} €
                                    </p>
                                @else
                                    <p class="text-3xl font-bold text-gray-900">
                                        {{ number_format($product->price, 2) }} €
                                    </p>
                                @endif
                            </div>

                            <!-- Statut du stock -->
                            <div class="flex items-center space-x-2">
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    ({{ $product->stock }} unités disponibles)
                                </span>
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2">
                                @if($product->isNewArrival)
                                    <span class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full">
                                        Nouvelle arrivée
                                    </span>
                                @endif
                                @if($product->isBestSeller)
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                                        Meilleure vente
                                    </span>
                                @endif
                                @if($product->isFeatured)
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 rounded-full">
                                        Mis en avant
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Description</h4>
                                <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                            </div>

                            @if($product->more_description)
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">Description détaillée</h4>
                                    <p class="mt-2 text-gray-600">{{ $product->more_description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Caractéristiques techniques -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Caractéristiques techniques</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($product->color)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Couleur</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->color }}</dd>
                                </div>
                            @endif

                            @if($product->size)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Taille</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->size }}</dd>
                                </div>
                            @endif

                            @if($product->weight)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Poids</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->weight }}</dd>
                                </div>
                            @endif

                            @if($product->dimensions)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Dimensions</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->dimensions }}</dd>
                                </div>
                            @endif

                            @if($product->material)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Matériau</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->material }}</dd>
                                </div>
                            @endif

                            @if($product->brand)
                                <div class="border rounded p-4">
                                    <dt class="text-sm font-medium text-gray-500">Marque</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->brand }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>