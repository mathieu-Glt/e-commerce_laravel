<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Produits en solde') }}
            </h2>
            <a href="{{ route('products.index') }}" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                Retour à la liste
            </a>
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
                                    <div class="relative">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">Aucune image</span>
                                            </div>
                                        @endif
                                        <!-- Badge solde -->
                                        <div
                                            class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            -{{ number_format((($product->regularPrice - $product->soldePrice) / $product->regularPrice) * 100) }}%
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                                        </div>

                                        <p class="text-gray-600 text-sm mb-4">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>

                                        <div class="flex justify-between items-center mb-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm line-through text-gray-500">
                                                    {{ number_format($product->regularPrice, 2) }} €
                                                </span>
                                                <span class="text-lg font-bold text-red-600">
                                                    {{ number_format($product->soldePrice, 2) }} €
                                                </span>
                                            </div>
                                            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                Voir détails
                                            </a>
                                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super-admin']))
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
                                            @endif
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
                            <p class="text-gray-500 text-lg">Aucun produit en solde actuellement.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>