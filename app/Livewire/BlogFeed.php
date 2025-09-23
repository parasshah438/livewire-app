<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogFeed extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $hasMorePages = true;

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function toggleLike($blogId)
    {
        $blog = Blog::find($blogId);
        if ($blog) {
            $blog->increment('likes');
        }
    }

    public function render()
    {
        $blogs = Blog::orderBy('created_at', 'desc')
            ->take($this->perPage)
            ->get();

        $totalBlogs = Blog::count();
        $this->hasMorePages = $blogs->count() < $totalBlogs;

        return view('livewire.blog-feed', [
            'blogs' => $blogs,
            'hasMorePages' => $this->hasMorePages
        ]);
    }
}