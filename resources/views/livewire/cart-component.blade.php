<div>
    <!-- Bouton panier avec compteur -->
    <button @click="$dispatch('open-cart')" class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
        <span class="sr-only">Panier</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if(count($cartItems) > 0)
            <span
                class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ count($cartItems) }}
            </span>
        @endif
    </button>

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
                                <div class="mt-4 space-y-4">
                                    @foreach($cartItems as $item)
                                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                                            <div class="flex items-center space-x-4">
                                                @if($item['image'])
                                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                                        class="w-12 h-12 object-cover rounded">
                                                @endif
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $item['name'] }}</h4>
                                                    <p class="text-sm text-gray-500">{{ $item['price'] }} € x
                                                        {{ $item['quantity'] }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="removeFromCart({{ $item['id'] }})"
                                                class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 border-t pt-4">
                                    <div class="flex justify-between font-semibold">
                                        <span>Total:</span>
                                        <span>{{ number_format($total, 2) }} €</span>
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
</div>