<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Produits') }}
            </h2>
            <a href="{{ route('products.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Ajouter un produit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Remplacer le formulaire existant par -->
                    <form action="{{ route('products.index') }}" method="GET" class="mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                            <!-- En-tête du formulaire -->
                            <div class="border-b pb-4">
                                <h3 class="text-lg font-medium text-gray-900">Filtrer les produits</h3>
                                <p class="mt-1 text-sm text-gray-500">Utilisez les filtres ci-dessous pour affiner votre
                                    recherche.</p>
                            </div>

                            <!-- Barre de recherche -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Rechercher un produit...">
                            </div>

                            <!-- Filtres en grille -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Catégories -->
                                <div class="space-y-2">
                                    <label for="category" class="block text-sm font-medium text-gray-700">
                                        <span class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            Catégorie
                                        </span>
                                    </label>
                                    <select name="category" id="category"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Toutes les catégories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Disponibilité -->
                                <div class="space-y-2">
                                    <label for="availability" class="block text-sm font-medium text-gray-700">
                                        <span class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Disponibilité
                                        </span>
                                    </label>
                                    <select name="availability" id="availability"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Tous les produits</option>
                                        <option value="1" {{ request('availability') == '1' ? 'selected' : '' }}>En stock
                                        </option>
                                        <option value="0" {{ request('availability') == '0' ? 'selected' : '' }}>Rupture
                                            de stock</option>
                                    </select>
                                </div>

                                <!-- Tri -->
                                <div class="space-y-2">
                                    <label for="sort" class="block text-sm font-medium text-gray-700">
                                        <span class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                            </svg>
                                            Trier par
                                        </span>
                                    </label>
                                    <select name="sort" id="sort"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus
                                            récents</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Prix croissant</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-3 pt-4 border-t">
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Réinitialiser
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Appliquer les filtres
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des produits -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                        @forelse($products as $product)
                            <div
                                class="bg-gradient-to-br from-white to-indigo-50 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                                <!-- Image avec badge de statut -->
                                <div class="relative">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-56 object-cover">
                                    @else
                                        <div
                                            class="w-full h-56 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <!-- Badge de stock -->
                                    <div class="absolute top-2 right-2">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenu -->
                                <div class="p-5 space-y-4 bg-white bg-opacity-90">
                                    <!-- En-tête -->
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 hover:text-indigo-600">
                                                {{ $product->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                        </div>
                                        <!-- Prix -->
                                        <div class="text-right">
                                            @if($product->soldePrice)
                                                <p class="text-sm line-through text-gray-400">
                                                    {{ number_format($product->regularPrice, 2) }} €
                                                </p>
                                                <p class="text-lg font-bold text-red-600">
                                                    {{ number_format($product->soldePrice, 2) }} €
                                                </p>
                                            @else
                                                <p class="text-lg font-bold text-gray-900">
                                                    {{ number_format($product->price, 2) }} €
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>

                                    <!-- Stock info -->
                                    <div class="text-sm text-gray-500">
                                        Stock disponible: {{ $product->stock }} unités
                                    </div>

                                    <!-- Actions -->
                                    <div class="pt-4 border-t grid grid-cols-2 gap-4">
                                        <!-- Première rangée de boutons -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="h-10 inline-flex items-center justify-center px-3 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Voir
                                            </a>
                                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full h-10 inline-flex items-center justify-center px-3 bg-cyan-600 text-white text-sm font-medium rounded-md hover:bg-cyan-700">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Panier
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Deuxième rangée de boutons -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="h-10 inline-flex items-center justify-center px-3 bg-amber-500 text-white text-sm font-medium rounded-md hover:bg-amber-600 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Modifier
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full h-10 inline-flex items-center justify-center px-3 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="text-center py-12 bg-gray-50 rounded-lg">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun produit trouvé</h3>
                                    <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale du panier -->
    <div x-data="{ open: false }" x-show="open" @open-cart.window="open = true" @keydown.escape.window="open = false"
        class="fixed inset-0 bg-gray-500 bg-opacity-75">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Votre Panier</h3>
                                <div class="mt-4 space-y-4" id="cartItems">
                                    <!-- Les articles du panier seront injectés ici -->
                                </div>
                                <div class="mt-4 border-t pt-4">
                                    <div class="flex justify-between font-semibold">
                                        <span>Total:</span>
                                        <span id="cartTotal">0.00 €</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" class="btn-primary" onclick="checkout()">Commander</button>
                        <button type="button" class="btn-secondary mr-3" @click="open = false">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Récupérer les éléments select
            const categorySelect = document.getElementById('category');
            const availabilitySelect = document.getElementById('availability');
            const sortSelect = document.getElementById('sort');

            // Fonction pour mettre à jour l'URL avec les paramètres
            function updateFilters() {
                const params = new URLSearchParams();

                if (categorySelect.value) {
                    params.set('category', categorySelect.value);
                }

                if (availabilitySelect.value) {
                    params.set('availability', availabilitySelect.value);
                }

                if (sortSelect.value) {
                    params.set('sort', sortSelect.value);
                }

                window.location.href = `${window.location.pathname}?${params.toString()}`;
            }

            // Ajouter les écouteurs d'événements
            categorySelect.addEventListener('change', updateFilters);
            availabilitySelect.addEventListener('change', updateFilters);
            sortSelect.addEventListener('change', updateFilters);

            // Définir les valeurs sélectionnées à partir de l'URL
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('category')) {
                categorySelect.value = urlParams.get('category');
            }

            if (urlParams.has('availability')) {
                availabilitySelect.value = urlParams.get('availability');
            }

            if (urlParams.has('sort')) {
                sortSelect.value = urlParams.get('sort');
            }
        });
    </script>

    <script>
        function addToCart(productId) {
            fetch(`/cart/add/${productId}`)
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 404) {
                            throw new Error('Produit non trouvé');
                        }
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    updateCartDisplay(data);
                    window.dispatchEvent(new CustomEvent('open-cart'));
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'ajout au panier: ' + error.message);
                });
        }

        function removeFromCart(productId) {
            fetch(`/cart/remove/${productId}`)
                .then(response => response.json())
                .then(data => {
                    updateCartDisplay(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression du produit');
                });
        }

        function updateCartDisplay(data) {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cart-count');

            // Mettre à jour le compteur dans la navigation
            if (cartCount) {
                cartCount.textContent = data.items.length;
                cartCount.classList.toggle('hidden', data.items.length === 0);
            }

            // Mettre à jour le contenu du panier
            if (cartItems) {
                cartItems.innerHTML = '';
                data.items.forEach(item => {
                    cartItems.innerHTML += `
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    ${item.image ? `<img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">` : ''}
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">${item.name}</h4>
                                    <p class="text-sm text-gray-500">${item.price} € x ${item.quantity}</p>
                                </div>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    `;
                });

                document.getElementById('cartTotal').textContent = `${data.total.toFixed(2)} €`;
            }
        }

        // Initialiser le panier au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/cart')
                .then(response => response.json())
                .then(data => {
                    updateCartDisplay(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        function checkout() {
            // À implémenter : redirection vers le paiement
            alert('Redirection vers le paiement...');
        }
    </script>
</x-app-layout>