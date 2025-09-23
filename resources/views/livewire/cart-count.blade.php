<div class="position-relative">
    <a href="{{ route('cart') }}" class="btn btn-outline-light position-relative">
        <i class="fas fa-shopping-cart"></i>
        @if($count > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $count > 99 ? '99+' : $count }}
                <span class="visually-hidden">items in cart</span>
            </span>
        @endif
    </a>
</div>