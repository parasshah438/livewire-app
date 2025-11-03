<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="fas fa-images me-2"></i>
                                Image Gallery
                            </h4>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Search images..."
                                    wire:model.live="search"
                                >
                                <a href="{{ route('sample-file-upload') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Upload
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Success/Error Messages -->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $images->total() }}</h3>
                                    <p class="mb-0">Total Images</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\Image::where('is_optimized', true)->count() }}</h3>
                                    <p class="mb-0">Optimized</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    @php
                                        $totalSize = \App\Models\Image::sum('size');
                                        $formattedSize = $totalSize >= 1048576 ? 
                                            number_format($totalSize / 1048576, 2) . ' MB' : 
                                            number_format($totalSize / 1024, 2) . ' KB';
                                    @endphp
                                    <h3>{{ $formattedSize }}</h3>
                                    <p class="mb-0">Total Size</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    @php
                                        $totalSavings = \App\Models\Image::whereNotNull('original_size')
                                            ->whereNotNull('optimized_size')
                                            ->get()
                                            ->sum(function($img) { return $img->original_size - $img->optimized_size; });
                                        $formattedSavings = $totalSavings >= 1048576 ? 
                                            number_format($totalSavings / 1048576, 2) . ' MB' : 
                                            number_format($totalSavings / 1024, 2) . ' KB';
                                    @endphp
                                    <h3>{{ $formattedSavings }}</h3>
                                    <p class="mb-0">Space Saved</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sorting Controls -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-secondary {{ $sortBy === 'created_at' ? 'active' : '' }}"
                                    wire:click="sortBy('created_at')"
                                >
                                    Date {{ $sortBy === 'created_at' && $sortDirection === 'asc' ? '↑' : '↓' }}
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-secondary {{ $sortBy === 'original_name' ? 'active' : '' }}"
                                    wire:click="sortBy('original_name')"
                                >
                                    Name {{ $sortBy === 'original_name' && $sortDirection === 'asc' ? '↑' : '↓' }}
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-secondary {{ $sortBy === 'size' ? 'active' : '' }}"
                                    wire:click="sortBy('size')"
                                >
                                    Size {{ $sortBy === 'size' && $sortDirection === 'asc' ? '↑' : '↓' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Images Grid -->
                    @if($images->count() > 0)
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100">
                                        <div class="position-relative">
                                            <img 
                                                src="{{ Storage::url($image->path) }}" 
                                                class="card-img-top" 
                                                alt="{{ $image->original_name }}"
                                                style="height: 200px; object-fit: cover;"
                                            >
                                            <div class="position-absolute top-0 end-0 p-2">
                                                @if($image->is_optimized)
                                                    <span class="badge bg-success">Optimized</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title text-truncate" title="{{ $image->original_name }}">
                                                {{ $image->original_name }}
                                            </h6>
                                            
                                            <div class="small text-muted mb-2">
                                                <div><strong>Size:</strong> {{ number_format($image->size / 1024, 2) }} KB</div>
                                                <div><strong>Type:</strong> {{ $image->type }}</div>
                                                <div><strong>Uploaded:</strong> {{ $image->created_at->format('M j, Y') }}</div>
                                                
                                                @if($image->original_size && $image->optimized_size)
                                                    @php
                                                        $savings = $image->original_size - $image->optimized_size;
                                                        $percentage = round(($savings / $image->original_size) * 100, 1);
                                                    @endphp
                                                    <div class="text-success">
                                                        <strong>Saved:</strong> {{ $percentage }}%
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Thumbnails Preview -->
                                            @if($image->thumbnails)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block mb-1">Thumbnails:</small>
                                                    <div class="d-flex gap-1">
                                                        @foreach($image->thumbnails as $size => $thumbnail)
                                                            <img 
                                                                src="{{ Storage::url($thumbnail) }}" 
                                                                class="img-thumbnail" 
                                                                style="width: 30px; height: 30px; object-fit: cover;"
                                                                title="{{ $size }}px"
                                                            >
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-auto">
                                                <div class="btn-group w-100" role="group">
                                                    <a href="{{ Storage::url($image->path) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($image->webp_path)
                                                        <a href="{{ Storage::url($image->webp_path) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           target="_blank">
                                                            WebP
                                                        </a>
                                                    @endif
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        wire:click="deleteImage({{ $image->id }})"
                                                        onclick="return confirm('Are you sure you want to delete this image?')"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $images->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No images found</h5>
                            <p class="text-muted">
                                @if($search)
                                    No images match your search criteria.
                                @else
                                    Upload your first image to get started!
                                @endif
                            </p>
                            <a href="{{ route('sample-file-upload') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Upload Images
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
