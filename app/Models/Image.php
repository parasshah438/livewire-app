<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'webp_path',
        'thumbnails',
        'original_name',
        'type',
        'size',
        'original_size',
        'optimized_size',
        'optimization_quality',
        'is_optimized',
        'sort_order'
    ];

    protected $casts = [
        'size' => 'integer',
        'original_size' => 'integer',
        'optimized_size' => 'integer',
        'sort_order' => 'integer',
        'thumbnails' => 'array',
        'is_optimized' => 'boolean',
    ];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getWebpUrlAttribute()
    {
        return $this->webp_path ? asset('storage/' . $this->webp_path) : null;
    }

    public function getThumbnailUrl($size)
    {
        if ($this->thumbnails && isset($this->thumbnails[$size])) {
            return asset('storage/' . $this->thumbnails[$size]);
        }
        return null;
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getOptimizationSavingsAttribute()
    {
        if ($this->original_size && $this->optimized_size) {
            $savings = $this->original_size - $this->optimized_size;
            $percentage = round(($savings / $this->original_size) * 100, 1);
            return [
                'bytes' => $savings,
                'percentage' => $percentage,
                'formatted' => $this->formatBytes($savings)
            ];
        }
        return null;
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getFileTypeIconAttribute()
    {
        $extension = strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc' => 'fas fa-file-word text-primary',
            'docx' => 'fas fa-file-word text-primary',
            'xls' => 'fas fa-file-excel text-success',
            'xlsx' => 'fas fa-file-excel text-success',
            'ppt' => 'fas fa-file-powerpoint text-warning',
            'pptx' => 'fas fa-file-powerpoint text-warning',
            'txt' => 'fas fa-file-alt text-secondary',
            'zip' => 'fas fa-file-archive text-info',
            'rar' => 'fas fa-file-archive text-info',
            'jpg' => 'fas fa-file-image text-primary',
            'jpeg' => 'fas fa-file-image text-primary',
            'png' => 'fas fa-file-image text-primary',
            'gif' => 'fas fa-file-image text-primary',
            'mp4' => 'fas fa-file-video text-danger',
            'avi' => 'fas fa-file-video text-danger',
            'mp3' => 'fas fa-file-audio text-success',
            'wav' => 'fas fa-file-audio text-success',
        ];
        
        return $icons[$extension] ?? 'fas fa-file text-secondary';
    }
}