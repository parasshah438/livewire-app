<div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Create toast container if it doesn't exist
            if (!document.querySelector('.toast-container')) {
                const toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            
            Livewire.on('show-toast', function (data) {
                showToast(data[0].type, data[0].message);
            });
            
            Livewire.on('cart-updated', function () {
                // Force refresh cart count
                Livewire.dispatch('refresh-cart-count');
            });
        });
        
        function showToast(type, message) {
            const toastContainer = document.querySelector('.toast-container');
            
            // Create toast HTML
            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${type === 'success' ? 'bg-success text-white' : 'bg-danger text-white'}">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                        <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 4000
            });
            
            toast.show();
            
            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function () {
                toastElement.remove();
            });
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .product-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .product-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .price-tag {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        .filter-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Custom Pagination Styles */
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: 2px solid transparent;
            color: #667eea;
            font-weight: 500;
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover {
            background-color: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: transparent;
            cursor: not-allowed;
        }
        
        .pagination .page-link i {
            font-size: 14px;
        }
        
        .pagination-lg .page-link {
            min-width: 45px;
            height: 45px;
            font-size: 1rem;
        }    </style>
    @endpush

    <div class="container-fluid py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-white mb-3">Our Products</h1>
                <p class="lead text-white-50">Discover amazing products at great prices</p>
            </div>

            <!-- Filters -->
            <div class="filter-card p-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search Products</label>
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Search products...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-select" wire:model.live="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Sort By</label>
                        <select class="form-select" wire:model.live="sortBy">
                            <option value="name">Name</option>
                            <option value="price">Price</option>
                            <option value="created_at">Newest</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Order</label>
                        <select class="form-select" wire:model.live="sortDirection">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label fw-semibold">Per Page</label>
                        <select class="form-select" wire:model.live="perPage">
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="48">48</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4 mb-5">
                @forelse($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card card h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ $product->image }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                <div class="stock-badge">
                                    {{ $product->stock }} in stock
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-secondary">{{ $product->category }}</span>
                                </div>
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="price-tag">${{ $product->price }}</span>
                                    <button class="btn btn-primary btn-sm" 
                                            wire:click="addToCart({{ $product->id }})"
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart me-1"></i>
                                        {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="filter-card p-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No products found</h4>
                                <p class="text-muted">Try adjusting your search or filter criteria.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center">
                    <div class="filter-card p-3">
                        <nav aria-label="Product pagination">
                            <ul class="pagination pagination-lg justify-content-center mb-0">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" wire:navigate>
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}" wire:navigate>{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" wire:navigate>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                        
                        {{-- Pagination Info --}}
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                            </small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>