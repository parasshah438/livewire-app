<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-compress-alt me-2"></i>
                        Optimized Image Upload
                    </h4>
                    <small class="text-muted">Upload images with automatic optimization using Spatie Image Optimizer</small>
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

                    @error('photo')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @enderror

                    <!-- Upload Form -->
                    <form wire:submit.prevent="uploadImage" enctype="multipart/form-data">
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
                                {{ $isUploading ? 'disabled' : '' }}
                            >
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Supported formats: JPG, PNG, GIF, WebP. Max size: 2MB (limited by server configuration)
                            </div>
                        </div>

                        <!-- Image Preview -->
                        @if ($photo)
                            <div class="mb-4">
                                <h6>Preview:</h6>
                                <div class="border rounded p-3 bg-light">
                                    <img src="{{ $photo->temporaryUrl() }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px; max-width: 100%;"
                                         alt="Preview">
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-file me-1"></i>
                                            {{ $photo->getClientOriginalName() }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-weight me-1"></i>
                                            Size: {{ $this->formatFileSize($photo->getSize()) }}
                                            @if ($photo->getSize() > $this->getMaxUploadSize())
                                                <span class="text-danger">
                                                    <i class="fas fa-exclamation-triangle ms-2"></i>
                                                    Too large! Max: {{ $this->getMaxUploadSizeFormatted() }}
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    <i class="fas fa-check ms-2"></i>
                                                    Size OK
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Upload Progress -->
                        @if ($isUploading)
                            <div class="mb-4">
                                <h6>
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    Processing Image...
                                </h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         style="width: {{ $uploadProgress }}%">
                                        {{ $uploadProgress }}%
                                    </div>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    @if ($uploadProgress == 20)
                                        Preparing image...
                                    @elseif ($uploadProgress == 40)
                                        Optimizing & generating formats...
                                    @elseif ($uploadProgress == 80)
                                        Creating thumbnails & WebP...
                                    @elseif ($uploadProgress == 100)
                                        Complete!
                                    @endif
                                </small>
                            </div>
                        @endif

                        <!-- Upload Button -->
                        <div class="d-grid">
                            <button 
                                type="submit" 
                                class="btn btn-primary btn-lg"
                                {{ $isUploading || !$photo || ($photo && $photo->getSize() > $this->getMaxUploadSize()) ? 'disabled' : '' }}
                            >
                                @if ($isUploading)
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    Processing...
                                @elseif ($photo && $photo->getSize() > $this->getMaxUploadSize())
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    File Too Large
                                @else
                                    <i class="fas fa-upload me-2"></i>
                                    Upload & Optimize Image
                                @endif
                            </button>
                        </div>
                    </form>

                    <!-- Uploaded Images -->
                    @if (count($uploadedImages) > 0)
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">
                                <i class="fas fa-images me-2"></i>
                                Uploaded Images ({{ count($uploadedImages) }})
                            </h5>
                            <div class="btn-group">
                                <button 
                                    wire:click="clearAll" 
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete all images?')"
                                >
                                    <i class="fas fa-trash me-1"></i>
                                    Clear All
                                </button>
                                <button 
                                    wire:click="resetSession" 
                                    class="btn btn-outline-warning btn-sm"
                                    title="Reset session data (for debugging)"
                                >
                                    <i class="fas fa-sync me-1"></i>
                                    Reset Session
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($uploadedImages as $image)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $image['url'] }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;"
                                             alt="{{ $image['original_name'] }}">
                                        
                                        <div class="card-body p-3">
                                            <h6 class="card-title text-truncate" title="{{ $image['original_name'] }}">
                                                {{ $image['original_name'] }}
                                            </h6>
                                            
                                            <div class="small text-muted mb-2">
                                                <div class="d-flex justify-content-between">
                                                    <span>Original:</span>
                                                    <span>{{ $this->formatFileSize($image['original_size']) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Optimized:</span>
                                                    <span>{{ $this->formatFileSize($image['optimized_size']) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fw-bold text-success">
                                                    <span>Saved:</span>
                                                    <span>{{ $image['compression_percentage'] }}%</span>
                                                </div>
                                                @if(isset($image['optimization_method']))
                                                    <div class="d-flex justify-content-between text-info mt-1">
                                                        <span><small>Method:</small></span>
                                                        <span><small>{{ $image['optimization_method'] }}</small></span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Additional features display -->
                                            @if(isset($image['has_webp']) && $image['has_webp'] || isset($image['has_thumbnails']) && $image['has_thumbnails'])
                                                <div class="small mb-2">
                                                    @if(isset($image['has_webp']) && $image['has_webp'])
                                                        <span class="badge bg-success me-1">
                                                            <i class="fas fa-check me-1"></i>WebP
                                                        </span>
                                                    @endif
                                                    @if(isset($image['has_thumbnails']) && $image['has_thumbnails'])
                                                        <span class="badge bg-info me-1">
                                                            <i class="fas fa-images me-1"></i>{{ count($image['thumbnails'] ?? []) }} Thumbnails
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            <div class="small text-muted mb-3">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $image['uploaded_at'] }}
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer p-2">
                                            <div class="d-grid gap-2">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ $image['url'] }}" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary btn-sm flex-fill">
                                                        <i class="fas fa-eye me-1"></i>
                                                        View Original
                                                    </a>
                                                    @if(isset($image['has_webp']) && $image['has_webp'] && isset($image['webp_url']))
                                                        <a href="{{ $image['webp_url'] }}" 
                                                           target="_blank" 
                                                           class="btn btn-outline-success btn-sm flex-fill">
                                                            <i class="fas fa-compress me-1"></i>
                                                            View WebP
                                                        </a>
                                                    @endif
                                                </div>
                                                @if(isset($image['has_thumbnails']) && $image['has_thumbnails'] && isset($image['thumbnails']) && !empty($image['thumbnails']))
                                                    <div class="d-flex gap-1">
                                                        @foreach($image['thumbnails'] as $size => $thumbPath)
                                                            <a href="{{ Storage::url($thumbPath) }}" 
                                                               target="_blank" 
                                                               class="btn btn-outline-info btn-sm flex-fill">
                                                                <i class="fas fa-image me-1"></i>
                                                                {{ $size }}px
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <button 
                                                    wire:click="deleteImage('{{ $image['id'] }}')" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this image{{ isset($image['has_webp']) && $image['has_webp'] || isset($image['has_thumbnails']) && $image['has_thumbnails'] ? ' and all its variants' : '' }}?')"
                                                >
                                                    <i class="fas fa-trash me-1"></i>
                                                    Delete{{ isset($image['has_webp']) && $image['has_webp'] || isset($image['has_thumbnails']) && $image['has_thumbnails'] ? ' All' : '' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Information Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Advanced Image Optimization
                    </h6>
                    <p class="card-text small mb-3">
                        This tool uses the <strong>ImageOptimizer Helper</strong> with multiple optimization techniques:
                        <strong>Spatie Image Optimizer</strong> with <strong>Intervention Image</strong> and PHP GD Library fallback.
                        Features include automatic resizing, WebP conversion, thumbnail generation, and progressive JPEG encoding.
                    </p>
                    
                    <!-- Features List -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="small fw-bold">✅ Current Features:</h6>
                            <ul class="small mb-0">
                                <li>Smart image compression</li>
                                <li>Automatic WebP generation</li>
                                <li>Multiple thumbnail sizes</li>
                                <li>Progressive JPEG encoding</li>
                                <li>Memory-efficient processing</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="small fw-bold">🎯 Output Formats:</h6>
                            <ul class="small mb-0">
                                <li>Optimized original format</li>
                                <li>Modern WebP format</li>
                                <li>Thumbnails: 150px, 300px, 600px</li>
                                <li>Responsive-ready images</li>
                                <li>Metadata removal</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Server Configuration Info -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading mb-2">
                            <i class="fas fa-server me-2"></i>
                            Server Upload Limits
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small>
                                    <strong>Max Upload Size:</strong> {{ $this->getMaxUploadSizeFormatted() }}<br>
                                    <strong>PHP upload_max_filesize:</strong> {{ ini_get('upload_max_filesize') }}<br>
                                    <strong>PHP post_max_size:</strong> {{ ini_get('post_max_size') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    <strong>For better optimization:</strong><br>
                                    Install jpegoptim, optipng, pngquant on your server.<br>
                                    Current: Using PHP GD Library fallback.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // File size validation
        const fileInput = document.getElementById('photo');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const maxSize = {{ $this->getMaxUploadSize() }}; // bytes
                    const fileSize = file.size;
                    
                    if (fileSize > maxSize) {
                        const maxSizeMB = (maxSize / (1024 * 1024)).toFixed(1);
                        const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(1);
                        
                        alert(`File is too large!\n\nYour file: ${fileSizeMB} MB\nMaximum allowed: ${maxSizeMB} MB\n\nPlease choose a smaller image or increase server upload limits.`);
                        
                        // Clear the input
                        e.target.value = '';
                        
                        // Trigger Livewire update
                        @this.set('photo', null);
                    }
                }
            });
        }
    });
</script>
@endpush