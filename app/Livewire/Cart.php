<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $cartCount = 0;

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $cartService = app(CartService::class);
        $this->cartItems = $cartService->getCartItems();
        $this->cartTotal = $cartService->getCartTotal();
        $this->cartCount = $cartService->getCartCount();
    }

    public function updateQuantity($productId, $quantity)
    {
        try {
            $cartService = app(CartService::class);
            $cartService->updateQuantity($productId, $quantity);
            $this->loadCart();
            $this->dispatch('cart-updated');
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Cart updated successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function removeItem($productId)
    {
        try {
            $cartService = app(CartService::class);
            $cartService->removeFromCart($productId);
            $this->loadCart();
            $this->dispatch('cart-updated');
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Item removed from cart!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function clearCart()
    {
        $cartService = app(CartService::class);
        $cartService->clearCart();
        $this->loadCart();
        $this->dispatch('cart-updated');
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Cart cleared successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}