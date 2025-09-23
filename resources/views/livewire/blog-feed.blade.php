<div class="container-fluid" style="max-width: 680px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-primary">
                <i class="fas fa-blog me-2"></i>Blog Feed
            </h2>
            <p class="text-muted">Discover amazing stories and insights</p>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="row" id="blog-posts">
        @foreach($blogs as $index => $blog)
            <div class="col-12 mb-4" wire:key="blog-{{ $blog->id }}">
                <div class="card border-0 shadow-sm h-100">
                    <!-- Post Header -->
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="text-white fw-bold">{{ substr($blog->author, 0, 1) }}</span>
                            </div>
                            <div>
                                <h6 class="card-title mb-1 fw-bold">{{ $blog->author }}</h6>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>{{ $blog->time_ago }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="card-body pt-0">
                        <h5 class="card-title fw-bold mb-3">{{ $blog->title }}</h5>
                        
                        @if($blog->image)
                            <img src="{{ $blog->image }}" 
                                 class="img-fluid rounded mb-3 w-100" 
                                 style="height: 300px; object-fit: cover;" 
                                 alt="Blog image">
                        @endif
                        
                        <p class="card-text text-muted">{{ $blog->excerpt }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <!-- Like Button -->
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                                    wire:click="toggleLike({{ $blog->id }})"
                                    wire:loading.attr="disabled">
                                <i class="far fa-heart me-1" wire:loading.remove wire:target="toggleLike({{ $blog->id }})"></i>
                                <i class="fas fa-spinner fa-spin me-1" wire:loading wire:target="toggleLike({{ $blog->id }})"></i>
                                <span>{{ number_format($blog->likes) }}</span>
                            </button>
                            
                            <!-- Comments -->
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="far fa-comment me-1"></i>
                                <span>{{ number_format($blog->comments) }}</span>
                            </button>
                            
                            <!-- Share -->
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="fas fa-share me-1"></i>
                                Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Load More Button -->
    @if($hasMorePages)
        <div class="row">
            <div class="col-12 text-center mb-5">
                <button class="btn btn-primary btn-lg rounded-pill px-5" 
                        wire:click="loadMore" 
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-plus me-2"></i>Load More Posts
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                    </span>
                </button>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="alert alert-info rounded-pill d-inline-block px-4">
                    <i class="fas fa-check-circle me-2"></i>You've reached the end of the feed!
                </div>
            </div>
        </div>
    @endif

    <!-- Infinite Scroll Trigger -->
    <div id="infinite-scroll-trigger" style="height: 10px;"></div>
</div>