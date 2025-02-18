<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe as StripeClient;
use Stripe\Checkout\Session as StripeSession;
use Exception;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }

        try {
            StripeClient::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item['name'],
                            'images' => [$item['image'] ? asset($item['image']) : null],
                        ],
                        'unit_amount' => (int) ($item['price'] * 100), // Stripe utilise les centimes
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            return view('checkout.create', [
                'sessionId' => $session->id,
                'stripeKey' => config('services.stripe.key')
            ]);
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Erreur lors de l\'initialisation du paiement : ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        // Vider le panier après un paiement réussi
        session()->forget('cart');
        
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
} 