<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageGallery extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteImage($imageId)
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
                
                session()->flash('success', 'Image deleted successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $images = Image::query()
            ->when($this->search, function ($query) {
                $query->where('original_name', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        return view('livewire.image-gallery', [
            'images' => $images
        ])->layout('layouts.app-livewire');
    }
}
