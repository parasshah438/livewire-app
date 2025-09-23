<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        
        if (!$product->isInStock($quantity)) {
            throw new \Exception('Not enough stock available');
        }

        $cartItem = $this->findCartItem($productId);

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if (!$product->isInStock($newQuantity)) {
                throw new \Exception('Not enough stock available');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::guest() ? session()->getId() : null,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return $cartItem;
    }

    public function updateQuantity($productId, $quantity)
    {
        $cartItem = $this->findCartItem($productId);
        
        if (!$cartItem) {
            throw new \Exception('Item not found in cart');
        }

        if ($quantity <= 0) {
            return $this->removeFromCart($productId);
        }

        $product = Product::findOrFail($productId);
        if (!$product->isInStock($quantity)) {
            throw new \Exception('Not enough stock available');
        }

        $cartItem->update(['quantity' => $quantity]);
        return $cartItem;
    }

    public function removeFromCart($productId)
    {
        $cartItem = $this->findCartItem($productId);
        
        if ($cartItem) {
            $cartItem->delete();
            return true;
        }
        
        return false;
    }

    public function getCartItems()
    {
        $query = CartItem::with('product');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->get();
    }

    public function getCartCount()
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->sum('quantity');
    }

    public function getCartTotal()
    {
        $cartItems = $this->getCartItems();
        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function clearCart()
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->delete();
    }

    public function mergeSessionCart()
    {
        if (Auth::check() && session()->has('cart_session_id')) {
            $sessionId = session()->get('cart_session_id');
            $sessionCartItems = CartItem::where('session_id', $sessionId)->get();

            foreach ($sessionCartItems as $sessionItem) {
                $userCartItem = CartItem::where('user_id', Auth::id())
                    ->where('product_id', $sessionItem->product_id)
                    ->first();

                if ($userCartItem) {
                    $userCartItem->increment('quantity', $sessionItem->quantity);
                } else {
                    $sessionItem->update([
                        'user_id' => Auth::id(),
                        'session_id' => null
                    ]);
                }
            }

            // Clean up duplicate session items
            CartItem::where('session_id', $sessionId)
                ->whereNotNull('user_id')
                ->delete();

            session()->forget('cart_session_id');
        }
    }

    private function findCartItem($productId)
    {
        $query = CartItem::where('product_id', $productId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->first();
    }
}