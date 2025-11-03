<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-upload me-2"></i>
                        Simple File Upload with Image Optimization
                    </h4>
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

                    @error('photo')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @enderror

                    <!-- Upload Form -->
                    <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="photo" class="form-label">
                                <i class="fas fa-image me-2"></i>
                                Select Image to Upload
                            </label>
                            <input 
                                type="file" 
                                class="form-control @error('photo') is-invalid @enderror" 
                                id="photo" 
                                wire:model="photo"
                                accept="image/*"
                            >
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Supported formats: JPG, PNG, GIF, WebP. Max size: 2MB. Files will be automatically optimized.
                            </div>
                        </div>

                        <!-- Upload Progress -->
                        <div wire:loading wire:target="photo" class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Loading file...</span>
                            </div>
                        </div>

                        <!-- Preview -->
                        @if ($photo)
                            <div class="mb-4">
                                <h6>Preview:</h6>
                                <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        @endif

                        <button 
                            type="submit" 
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="uploadFile"
                            @disabled(!$photo)
                        >
                            <span wire:loading.remove wire:target="uploadFile">
                                <i class="fas fa-upload me-2"></i>
                                Upload & Optimize
                            </span>
                            <span wire:loading wire:target="uploadFile">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Processing...
                            </span>
                        </button>
                    </form>

                    <!-- Uploaded Files -->
                    @if (count($uploadedImages) > 0)
                        <hr class="my-4">
                        <h5>
                            <i class="fas fa-images me-2"></i>
                            Uploaded Images ({{ count($uploadedImages) }})
                        </h5>
                        
                        <div class="row">
                            @foreach ($uploadedImages as $image)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $image['original_name'] }}</small>
                                            <button 
                                                type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                wire:click="deleteFile({{ $image['id'] }})"
                                                onclick="return confirm('Are you sure you want to delete this image?')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <!-- Main optimized image -->
                                            <img 
                                                src="{{ Storage::url($image['path']) }}" 
                                                class="img-fluid mb-3" 
                                                alt="{{ $image['original_name'] }}"
                                                style="max-height: 200px; width: 100%; object-fit: cover;"
                                            >
                                            
                                            <!-- File info with optimization details -->
                                            <div class="small text-muted mb-2">
                                                <div><strong>Uploaded:</strong> {{ \Carbon\Carbon::parse($image['created_at'])->format('Y-m-d H:i:s') }}</div>
                                                <div><strong>Type:</strong> {{ $image['type'] }}</div>
                                                <div><strong>Size:</strong> {{ number_format($image['size'] / 1024, 2) }} KB</div>
                                                @if($image['original_size'] && $image['optimized_size'])
                                                    @php
                                                        $savings = $image['original_size'] - $image['optimized_size'];
                                                        $percentage = round(($savings / $image['original_size']) * 100, 1);
                                                    @endphp
                                                    <div><strong>Optimization:</strong> 
                                                        <span class="text-success">
                                                            {{ number_format($savings / 1024, 2) }} KB saved ({{ $percentage }}%)
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($image['is_optimized'])
                                                    <div><strong>Status:</strong> 
                                                        <span class="badge bg-success">Optimized</span>
                                                        <span class="badge bg-info">Quality: {{ $image['optimization_quality'] }}%</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Thumbnails -->
                                            @if($image['thumbnails'])
                                                <div class="mb-2">
                                                    <small class="text-muted d-block mb-1">Thumbnails:</small>
                                                    <div class="d-flex gap-1">
                                                        @foreach($image['thumbnails'] as $size => $thumbnail)
                                                            <img 
                                                                src="{{ Storage::url($thumbnail) }}" 
                                                                class="img-thumbnail" 
                                                                style="width: 50px; height: 50px; object-fit: cover;"
                                                                title="{{ $size }}px"
                                                            >
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Download links -->
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ Storage::url($image['path']) }}" 
                                                   class="btn btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="fas fa-download me-1"></i>Original
                                                </a>
                                                @if($image['webp_path'])
                                                    <a href="{{ Storage::url($image['webp_path']) }}" 
                                                       class="btn btn-outline-success" 
                                                       target="_blank">
                                                        <i class="fas fa-download me-1"></i>WebP
                                                    </a>
                                                @endif
                                                @if($image['thumbnails'])
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                                            <i class="fas fa-download me-1"></i>Thumbs
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach($image['thumbnails'] as $size => $thumbnail)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ Storage::url($thumbnail) }}" target="_blank">
                                                                        {{ $size }}px
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <hr class="my-4">
                        <div class="text-center text-muted">
                            <i class="fas fa-images fa-3x mb-3"></i>
                            <p>No images uploaded yet. Upload your first image to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>