<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Mon Panier') }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Retour aux produits
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(count($cart) > 0)
                        <div class="space-y-4">
                            <!-- En-tête du tableau -->
                            <div
                                class="hidden md:grid md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-t-md font-medium text-gray-700">
                                <div class="col-span-2">Produit</div>
                                <div>Prix unitaire</div>
                                <div>Quantité</div>
                                <div>Total</div>
                            </div>

                            <!-- Liste des produits -->
                            @foreach($cart as $id => $details)
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-4 border rounded-md items-center">
                                    <!-- Image et nom du produit -->
                                    <div class="col-span-2 flex items-center space-x-4">
                                        @if($details['image'])
                                            <img src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}"
                                                class="w-20 h-20 object-cover rounded-md">
                                        @endif
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $details['name'] }}</h3>
                                            <p class="text-sm text-gray-500 md:hidden">
                                                {{ number_format($details['price'], 2) }}€ x {{ $details['quantity'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Prix unitaire -->
                                    <div class="hidden md:block">
                                        {{ number_format($details['price'], 2) }}€
                                    </div>

                                    <!-- Quantité -->
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                                max="99"
                                                class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Total par produit -->
                                    <div class="flex items-center justify-between md:justify-start">
                                        <span class="font-medium">
                                            {{ number_format($details['price'] * $details['quantity'], 2) }}€
                                        </span>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Résumé et actions -->
                            <div class="mt-8 border-t pt-8">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                    <div class="text-gray-700">
                                        <p class="text-lg font-medium">Total du panier :</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ number_format($total, 2) }}€</p>
                                    </div>
                                    <div class="mt-4 md:mt-0 space-x-4">
                                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                                Vider le panier
                                            </button>
                                        </form>
                                        <a href="{{ route('checkout.create') }}"
                                            class="inline-block px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                            Passer la commande
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Votre panier est vide</h3>
                            <p class="mt-1 text-gray-500">Commencez vos achats en parcourant nos produits.</p>
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Voir les produits
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>