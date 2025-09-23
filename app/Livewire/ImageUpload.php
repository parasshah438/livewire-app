<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Image;
use Illuminate\Support\Str;

class ImageUpload extends Component
{
    use WithFileUploads;

    public $singleImage;
    public $multipleImages = [];
    public $uploadedImages = [];
    public $title = 'Image Upload & Preview Demo';

    protected $rules = [
        'singleImage' => 'nullable|image|max:2048',
        'multipleImages.*' => 'image|max:2048',
    ];

    protected $messages = [
        'singleImage.image' => 'The file must be an image.',
        'singleImage.max' => 'The image size must not exceed 2MB.',
        'multipleImages.*.image' => 'All files must be images.',
        'multipleImages.*.max' => 'Each image size must not exceed 2MB.',
    ];

    public function updatedSingleImage()
    {
        $this->validateOnly('singleImage');
    }

    public function updatedMultipleImages()
    {
        $this->validate([
            'multipleImages.*' => 'image|max:2048',
        ]);
    }

    public function saveSingleImage()
    {
        $this->validate([
            'singleImage' => 'required|image|max:2048',
        ]);

        $originalName = $this->singleImage->getClientOriginalName();
        $filename = Str::uuid() . '.' . $this->singleImage->getClientOriginalExtension();
        $path = $this->singleImage->storeAs('images', $filename, 'public');

        Image::create([
            'name' => $filename,
            'path' => $path,
            'original_name' => $originalName,
            'type' => $this->singleImage->getMimeType(),
            'size' => $this->singleImage->getSize(),
        ]);

        $this->singleImage = null;
        session()->flash('success', 'Single image uploaded successfully!');
        $this->loadUploadedImages();
    }

    public function saveMultipleImages()
    {
        $this->validate([
            'multipleImages' => 'required|array|min:1',
            'multipleImages.*' => 'image|max:2048',
        ]);

        foreach ($this->multipleImages as $image) {
            $originalName = $image->getClientOriginalName();
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');

            Image::create([
                'name' => $filename,
                'path' => $path,
                'original_name' => $originalName,
                'type' => $image->getMimeType(),
                'size' => $image->getSize(),
            ]);
        }

        $this->multipleImages = [];
        session()->flash('success', count($this->multipleImages) . ' images uploaded successfully!');
        $this->loadUploadedImages();
    }

    public function removeImage($imageId)
    {
        $image = Image::find($imageId);
        if ($image) {
            // Delete file from storage
            if (\Storage::disk('public')->exists($image->path)) {
                \Storage::disk('public')->delete($image->path);
            }
            
            // Delete record from database
            $image->delete();
            
            session()->flash('success', 'Image deleted successfully!');
            $this->loadUploadedImages();
        }
    }

    public function removeSinglePreview()
    {
        $this->singleImage = null;
    }

    public function removeMultiplePreview($index)
    {
        unset($this->multipleImages[$index]);
        $this->multipleImages = array_values($this->multipleImages);
    }

    public function loadUploadedImages()
    {
        $this->uploadedImages = Image::latest()->get();
    }

    public function mount()
    {
        $this->loadUploadedImages();
    }

    public function render()
    {
        return view('livewire.image-upload')
            ->layout('layouts.app');
    }
}