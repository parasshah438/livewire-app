<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary mb-1">{{ $title }}</h2>
                    <p class="text-muted mb-0">Upload single or multiple images with live preview</p>
                </div>
                <div class="badge bg-info fs-6">
                    Total Images: {{ count($uploadedImages) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Single Image Upload -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>Single Image Upload
                    </h5>
                </div>
                <div class="card-body">
                    <div class="upload-zone border-2 border-dashed border-primary rounded-3 p-4 text-center position-relative"
                         style="min-height: 200px;">
                        
                        @if ($singleImage)
                            <!-- Preview -->
                            <div class="position-relative d-inline-block">
                                <img src="{{ $singleImage->temporaryUrl() }}" 
                                     class="img-fluid rounded shadow" 
                                     style="max-height: 150px;" 
                                     alt="Preview">
                                <button type="button" 
                                        wire:click="removeSinglePreview"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle rounded-circle p-1"
                                        style="width: 25px; height: 25px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-3">
                                <p class="mb-1 fw-semibold">{{ $singleImage->getClientOriginalName() }}</p>
                                <small class="text-muted">{{ round($singleImage->getSize() / 1024, 2) }} KB</small>
                            </div>
                        @else
                            <!-- Upload Area -->
                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                <i class="fas fa-cloud-upload-alt text-primary mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-primary mb-2">Drop your image here or click to browse</h6>
                                <p class="text-muted mb-0">Supports: JPG, PNG, GIF (Max: 2MB)</p>
                            </div>
                        @endif

                        <input type="file" 
                               wire:model="singleImage" 
                               accept="image/*"
                               class="position-absolute top-0 start-0 w-100 h-100 opacity-0" 
                               style="cursor: pointer;">
                    </div>

                    @error('singleImage')
                        <div class="text-danger mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    @if ($singleImage)
                        <div class="d-grid mt-3">
                            <button type="button" 
                                    wire:click="saveSingleImage" 
                                    class="btn btn-primary"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save me-2"></i>Save Image
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin me-2"></i>Saving...
                                </span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Multiple Images Upload -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-images me-2"></i>Multiple Images Upload
                    </h5>
                </div>
                <div class="card-body">
                    <div class="upload-zone border-2 border-dashed border-success rounded-3 p-4 text-center position-relative"
                         style="min-height: 200px;">
                        
                        @if (count($multipleImages) > 0)
                            <!-- Preview Grid -->
                            <div class="row g-2">
                                @foreach ($multipleImages as $index => $image)
                                    <div class="col-4">
                                        <div class="position-relative">
                                            <img src="{{ $image->temporaryUrl() }}" 
                                                 class="img-fluid rounded shadow w-100" 
                                                 style="height: 80px; object-fit: cover;" 
                                                 alt="Preview {{ $index + 1 }}">
                                            <button type="button" 
                                                    wire:click="removeMultiplePreview({{ $index }})"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle rounded-circle p-1"
                                                    style="width: 20px; height: 20px; font-size: 10px;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-3 mb-0 text-success fw-semibold">
                                {{ count($multipleImages) }} image(s) selected
                            </p>
                        @else
                            <!-- Upload Area -->
                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                <i class="fas fa-images text-success mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-success mb-2">Drop multiple images here or click to browse</h6>
                                <p class="text-muted mb-0">Supports: JPG, PNG, GIF (Max: 2MB each)</p>
                            </div>
                        @endif

                        <input type="file" 
                               wire:model="multipleImages" 
                               accept="image/*"
                               multiple
                               class="position-absolute top-0 start-0 w-100 h-100 opacity-0" 
                               style="cursor: pointer;">
                    </div>

                    @error('multipleImages.*')
                        <div class="text-danger mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    @if (count($multipleImages) > 0)
                        <div class="d-grid mt-3">
                            <button type="button" 
                                    wire:click="saveMultipleImages" 
                                    class="btn btn-success"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save me-2"></i>Save All Images
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin me-2"></i>Saving...
                                </span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Uploaded Images Gallery -->
    @if (count($uploadedImages) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-photo-video me-2"></i>Uploaded Images Gallery
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($uploadedImages as $image)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="position-relative">
                                            <img src="{{ $image->url }}" 
                                                 class="card-img-top" 
                                                 style="height: 150px; object-fit: cover;" 
                                                 alt="{{ $image->original_name }}">
                                            <button type="button" 
                                                    wire:click="removeImage({{ $image->id }})"
                                                    wire:confirm="Are you sure you want to delete this image?"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title small mb-1" title="{{ $image->original_name }}">
                                                {{ Str::limit($image->original_name, 20) }}
                                            </h6>
                                            <small class="text-muted">
                                                <div>{{ round($image->size / 1024, 2) }} KB</div>
                                                <div>{{ $image->created_at->format('M d, Y') }}</div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-image text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted">No images uploaded yet</h5>
                        <p class="text-muted">Upload your first image using the forms above</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .upload-zone {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-zone:hover {
        background-color: rgba(0, 123, 255, 0.05);
        border-color: #0d6efd !important;
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add drag and drop functionality
    document.addEventListener('DOMContentLoaded', function() {
        const uploadZones = document.querySelectorAll('.upload-zone');
        
        uploadZones.forEach(zone => {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                zone.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                zone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                zone.addEventListener(eventName, unhighlight, false);
            });
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            e.currentTarget.classList.add('border-primary', 'bg-light');
        }

        function unhighlight(e) {
            e.currentTarget.classList.remove('border-primary', 'bg-light');
        }
    });
</script>
@endpush