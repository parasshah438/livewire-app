<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = [
        'cart-updated' => 'updateCount',
        'refresh-cart-count' => 'updateCount'
    ];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $cartService = app(CartService::class);
        $this->count = $cartService->getCartCount();
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}