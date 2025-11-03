<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Helpers\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class OptimizedImageUpload extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048')] // 2MB Max (matching PHP settings)
    public $photo;

    public $uploadedImages = [];
    public $isUploading = false;
    public $uploadProgress = 0;

    public function mount()
    {
        // Load previously uploaded images and normalize old data
        $this->loadUploadedImages();
        $this->normalizeImageData();
    }

    private function normalizeImageData()
    {
        // Ensure all images have the new array keys with default values
        $updated = false;
        foreach ($this->uploadedImages as &$image) {
            if (!isset($image['has_webp'])) {
                $image['has_webp'] = false;
                $updated = true;
            }
            if (!isset($image['webp_path'])) {
                $image['webp_path'] = null;
                $updated = true;
            }
            if (!isset($image['webp_url'])) {
                $image['webp_url'] = null;
                $updated = true;
            }
            if (!isset($image['has_thumbnails'])) {
                $image['has_thumbnails'] = false;
                $updated = true;
            }
            if (!isset($image['thumbnails'])) {
                $image['thumbnails'] = [];
                $updated = true;
            }
            if (!isset($image['optimization_method'])) {
                $image['optimization_method'] = 'Legacy Upload';
                $updated = true;
            }
        }
        
        // Save the normalized data if any updates were made
        if ($updated) {
            $this->saveUploadedImages();
        }
    }

    public function getMaxUploadSize()
    {
        $maxUpload = $this->convertToBytes(ini_get('upload_max_filesize'));
        $maxPost = $this->convertToBytes(ini_get('post_max_size'));
        return min($maxUpload, $maxPost);
    }

    public function getMaxUploadSizeFormatted()
    {
        return $this->formatFileSize($this->getMaxUploadSize());
    }

    private function convertToBytes($value)
    {
        $unit = strtolower(substr($value, -1));
        $number = (int) $value;
        
        switch ($unit) {
            case 'g':
                return $number * 1024 * 1024 * 1024;
            case 'm':
                return $number * 1024 * 1024;
            case 'k':
                return $number * 1024;
            default:
                return $number;
        }
    }

    public function uploadImage()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('photo', 'Please select a valid image file (max size: ' . $this->getMaxUploadSizeFormatted() . ')');
            return;
        }

        if (!$this->photo) {
            $this->addError('photo', 'Please select an image to upload.');
            return;
        }

        // Check if file size exceeds server limits
        if ($this->photo->getSize() > $this->getMaxUploadSize()) {
            $this->addError('photo', 'File is too large. Maximum allowed size is ' . $this->getMaxUploadSizeFormatted() . '. Your file is ' . $this->formatFileSize($this->photo->getSize()));
            return;
        }

        $this->isUploading = true;
        $this->uploadProgress = 0;

        try {
            $this->uploadProgress = 20;

            // Get original file size
            $originalSize = $this->photo->getSize();

            $this->uploadProgress = 40;

            // Use your ImageOptimizer helper
            $result = ImageOptimizer::optimizeUploadedImage($this->photo, 'uploads/optimized', [
                'quality' => 85,
                'maxWidth' => 1200,
                'maxHeight' => 1200,
                'generateWebP' => true,
                'generateThumbnails' => true,
                'thumbnailSizes' => [150, 300, 600],
            ]);

            $this->uploadProgress = 80;

            // Get optimized file size
            $optimizedPath = storage_path('app/public/' . $result['optimized']);
            $optimizedSize = file_exists($optimizedPath) ? filesize($optimizedPath) : $originalSize;

            // Calculate compression percentage
            $compressionPercentage = $originalSize > 0 ? round((($originalSize - $optimizedSize) / $originalSize) * 100, 2) : 0;

            $this->uploadProgress = 100;

            // Store comprehensive image information
            $imageData = [
                'id' => uniqid(),
                'filename' => basename($result['optimized']),
                'original_name' => $this->photo->getClientOriginalName(),
                'path' => $result['optimized'],
                'url' => Storage::url($result['optimized']),
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
                'compression_percentage' => $compressionPercentage,
                'optimization_method' => 'ImageOptimizer Helper',
                'has_webp' => isset($result['webp']),
                'webp_path' => $result['webp'] ?? null,
                'webp_url' => isset($result['webp']) ? Storage::url($result['webp']) : null,
                'has_thumbnails' => isset($result['thumbnails']) && !empty($result['thumbnails']),
                'thumbnails' => $result['thumbnails'] ?? [],
                'uploaded_at' => now()->format('Y-m-d H:i:s')
            ];

            $this->uploadedImages[] = $imageData;
            $this->saveUploadedImages();

            // Reset the photo input
            $this->photo = null;

            $message = "Image uploaded and optimized successfully! Reduced size by {$compressionPercentage}%";
            if ($imageData['has_webp']) {
                $message .= " (WebP version created)";
            }
            if ($imageData['has_thumbnails']) {
                $message .= " (" . count($imageData['thumbnails']) . " thumbnails generated)";
            }

            session()->flash('success', $message);

        } catch (\Exception $e) {
            $this->addError('photo', 'Error uploading image: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
            $this->uploadProgress = 0;
        }
    }

    public function deleteImage($imageId)
    {
        $imageIndex = collect($this->uploadedImages)->search(function ($image) use ($imageId) {
            return $image['id'] === $imageId;
        });

        if ($imageIndex !== false) {
            $image = $this->uploadedImages[$imageIndex];
            
            // Delete the main optimized file
            if (Storage::disk('public')->exists($image['path'])) {
                Storage::disk('public')->delete($image['path']);
            }

            // Delete WebP version if exists
            $hasWebp = isset($image['has_webp']) && $image['has_webp'];
            if ($hasWebp && !empty($image['webp_path']) && Storage::disk('public')->exists($image['webp_path'])) {
                Storage::disk('public')->delete($image['webp_path']);
            }

            // Delete thumbnails if exist
            $hasThumbnails = isset($image['has_thumbnails']) && $image['has_thumbnails'];
            if ($hasThumbnails && !empty($image['thumbnails'])) {
                foreach ($image['thumbnails'] as $thumbPath) {
                    if (Storage::disk('public')->exists($thumbPath)) {
                        Storage::disk('public')->delete($thumbPath);
                    }
                }
            }

            // Remove from array
            unset($this->uploadedImages[$imageIndex]);
            $this->uploadedImages = array_values($this->uploadedImages);
            
            $this->saveUploadedImages();

            $message = 'Image deleted successfully!';
            if ($hasWebp || $hasThumbnails) {
                $message = 'Image and all its variants deleted successfully!';
            }
            
            session()->flash('success', $message);
        }
    }

    public function clearAll()
    {
        // Delete all files from storage
        foreach ($this->uploadedImages as $image) {
            // Delete main file
            if (Storage::disk('public')->exists($image['path'])) {
                Storage::disk('public')->delete($image['path']);
            }

            // Delete WebP version
            $hasWebp = isset($image['has_webp']) && $image['has_webp'];
            if ($hasWebp && !empty($image['webp_path']) && Storage::disk('public')->exists($image['webp_path'])) {
                Storage::disk('public')->delete($image['webp_path']);
            }

            // Delete thumbnails
            $hasThumbnails = isset($image['has_thumbnails']) && $image['has_thumbnails'];
            if ($hasThumbnails && !empty($image['thumbnails'])) {
                foreach ($image['thumbnails'] as $thumbPath) {
                    if (Storage::disk('public')->exists($thumbPath)) {
                        Storage::disk('public')->delete($thumbPath);
                    }
                }
            }
        }

        // Clear the array
        $this->uploadedImages = [];
        $this->saveUploadedImages();

        session()->flash('success', 'All images and variants cleared successfully!');
    }

    public function resetSession()
    {
        // Clear session data without deleting files (for debugging)
        session()->forget('uploaded_optimized_images');
        $this->uploadedImages = [];
        session()->flash('success', 'Session data reset successfully!');
    }

    private function loadUploadedImages()
    {
        $this->uploadedImages = session()->get('uploaded_optimized_images', []);
    }

    private function saveUploadedImages()
    {
        session()->put('uploaded_optimized_images', $this->uploadedImages);
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function render()
    {
        return view('livewire.optimized-image-upload')->layout('layouts.app-livewire');
    }
}