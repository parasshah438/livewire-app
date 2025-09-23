<div>
    @push('styles')
    <style>
        .cart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .cart-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .quantity-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .quantity-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .total-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
        }
        
        .btn-checkout {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .empty-cart {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 4rem 2rem;
        }
    </style>
    @endpush

    <div class="container-fluid py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-white mb-3">Shopping Cart</h1>
                <p class="lead text-white-50">Review your items before checkout</p>
            </div>

            @if(count($cartItems) > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">Cart Items ({{ $cartCount }})</h4>
                                <button class="btn btn-outline-danger btn-sm" wire:click="clearCart" 
                                        onclick="return confirm('Are you sure you want to clear your cart?')">
                                    <i class="fas fa-trash me-1"></i>Clear Cart
                                </button>
                            </div>

                            @foreach($cartItems as $item)
                                <div class="cart-item py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="{{ $item->product->image }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 80px; object-fit: cover;" 
                                                 alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                            <p class="text-muted small mb-1">{{ $item->product->category }}</p>
                                            <span class="badge bg-secondary">Stock: {{ $item->product->stock }}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="fw-bold text-primary">${{ $item->product->price }}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        wire:click="updateQuantity({{ $item->product->id }}, {{ $item->quantity - 1 }})">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control quantity-control text-center" 
                                                       value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                       wire:change="updateQuantity({{ $item->product->id }}, $event.target.value)">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        wire:click="updateQuantity({{ $item->product->id }}, {{ $item->quantity + 1 }})"
                                                        {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <span class="fw-bold">${{ number_format($item->quantity * $item->product->price, 2) }}</span>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button class="btn btn-outline-danger btn-sm" 
                                                    wire:click="removeItem({{ $item->product->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="total-section">
                            <h4 class="fw-bold mb-4">Order Summary</h4>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal ({{ $cartCount }} items)</span>
                                <span>${{ number_format($cartTotal, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax</span>
                                <span>${{ number_format($cartTotal * 0.1, 2) }}</span>
                            </div>
                            
                            <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.3);">
                            
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="fw-bold">Total</h5>
                                <h5 class="fw-bold">${{ number_format($cartTotal * 1.1, 2) }}</h5>
                            </div>
                            
                            <button class="btn btn-checkout w-100 mb-3">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </button>
                            
                            <a href="{{ route('products') }}" class="btn btn-outline-light w-100">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="empty-cart text-center">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                            <h3 class="fw-bold text-muted mb-3">Your cart is empty</h3>
                            <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>