<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Helpers\ImageOptimizer;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class SampleFileUpload extends Component
{
    use WithFileUploads;
    
    #[Validate('required|image|max:2048')] // 2MB max
    public $photo;
    
    public $uploadedImages = [];

    public function mount()
    {
        // Load existing images
        $this->loadImages();
    }

    public function loadImages()
    {
        $this->uploadedImages = Image::latest()->get()->toArray();
    }

    public function uploadFile()
    {
        $this->validate();

        try {
            // Get original file size
            $originalSize = $this->photo->getSize();
            
            // Use ImageOptimizer to process the uploaded file
            $result = ImageOptimizer::optimizeUploadedImage(
                $this->photo,
                'sample-uploads',
                [
                    'quality' => 85,
                    'maxWidth' => 1200,
                    'maxHeight' => 1200,
                    'generateWebP' => true,
                    'generateThumbnails' => true,
                    'thumbnailSizes' => [150, 300, 600],
                ]
            );

            // Get optimized file size
            $optimizedPath = storage_path('app/public/' . $result['optimized']);
            $optimizedSize = file_exists($optimizedPath) ? filesize($optimizedPath) : $originalSize;

            // Create image record in database
            $image = Image::create([
                'name' => pathinfo($this->photo->getClientOriginalName(), PATHINFO_FILENAME),
                'original_name' => $this->photo->getClientOriginalName(),
                'path' => $result['optimized'],
                'webp_path' => $result['webp'] ?? null,
                'thumbnails' => $result['thumbnails'] ?? null,
                'type' => $this->photo->getMimeType(),
                'size' => $optimizedSize,
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
                'optimization_quality' => '85',
                'is_optimized' => true,
            ]);

            // Reload images to show the new upload
            $this->loadImages();

            session()->flash('success', 'File uploaded, optimized, and saved to database successfully!');
            
            // Reset the file input
            $this->reset('photo');

        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function deleteFile($imageId)
    {
        try {
            $image = Image::find($imageId);
            
            if ($image) {
                // Delete files from storage
                Storage::disk('public')->delete($image->path);
                if ($image->webp_path) {
                    Storage::disk('public')->delete($image->webp_path);
                }
                if ($image->thumbnails) {
                    foreach ($image->thumbnails as $thumbnail) {
                        Storage::disk('public')->delete($thumbnail);
                    }
                }
                
                // Delete from database
                $image->delete();
                
                // Reload images
                $this->loadImages();
                
                session()->flash('success', 'Image deleted successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.sample-file-upload')->layout('layouts.app-livewire');
    }
}
