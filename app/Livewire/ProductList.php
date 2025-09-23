<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function addToCart($productId, $quantity = 1)
    {
        try {
            $cartService = app(CartService::class);
            $cartService->addToCart($productId, $quantity);
            
            $this->dispatch('cart-updated');
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Product added to cart successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $query = Product::active()->inStock();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        $products = $query->orderBy($this->sortBy, $this->sortDirection)
                         ->paginate($this->perPage);

        $categories = Product::distinct()->pluck('category');

        return view('livewire.product-list', compact('products', 'categories'));
    }
}