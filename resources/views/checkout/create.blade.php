<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Finaliser votre commande</h3>
                        <button id="checkout-button" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Procéder au paiement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe('{{ $stripeKey }}');
            const button = document.getElementById('checkout-button');

            button.addEventListener('click', function(e) {
                e.preventDefault();
                button.disabled = true;
                
                stripe.redirectToCheckout({
                    sessionId: '{{ $sessionId }}'
                }).then(function (result) {
                    if (result.error) {
                        button.disabled = false;
                        alert(result.error.message);
                    }
                }).catch(function(error) {
                    button.disabled = false;
                    console.error('Error:', error);
                    alert('Une erreur est survenue.');
                });
            });
        });
    </script>
</x-app-layout> 