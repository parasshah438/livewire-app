<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Optimization Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the ImageOptimizer helper class.
    |
    */

    // Default image quality (1-100)
    'quality' => env('IMAGE_QUALITY', 85),

    // Maximum dimensions for resizing
    'max_width' => env('IMAGE_MAX_WIDTH', 1200),
    'max_height' => env('IMAGE_MAX_HEIGHT', 1200),

    // File size limits
    'max_file_size' => env('IMAGE_MAX_FILE_SIZE', 10 * 1024 * 1024), // 10MB

    // Allowed file types
    'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],

    // WebP generation
    'generate_webp' => env('IMAGE_GENERATE_WEBP', true),
    'webp_quality' => env('IMAGE_WEBP_QUALITY', 80),

    // Thumbnail generation
    'generate_thumbnails' => env('IMAGE_GENERATE_THUMBNAILS', true),
    'thumbnail_sizes' => [150, 300, 600],

    // Responsive image breakpoints
    'responsive_breakpoints' => [
        'sm' => 576,
        'md' => 768,
        'lg' => 992,
        'xl' => 1200
    ],

    // Optimization settings
    'preserve_metadata' => env('IMAGE_PRESERVE_METADATA', false),
    'enable_backup' => env('IMAGE_ENABLE_BACKUP', true),
    'memory_limit' => env('IMAGE_MEMORY_LIMIT', '512M'),
    'time_limit' => env('IMAGE_TIME_LIMIT', 120),

    // Storage settings
    'default_disk' => env('IMAGE_STORAGE_DISK', 'public'),
    'default_directory' => env('IMAGE_DEFAULT_DIRECTORY', 'uploads'),

    // Optimization method preferences
    'prefer_spatie_optimizer' => env('IMAGE_PREFER_SPATIE', true),
    'gd_fallback' => env('IMAGE_GD_FALLBACK', true),

    // Validation rules
    'validation' => [
        'min_width' => 100,
        'min_height' => 100,
        'max_width' => 4000,
        'max_height' => 4000,
    ],

    // Performance monitoring
    'log_optimization_stats' => env('IMAGE_LOG_STATS', true),
    'track_compression_ratio' => env('IMAGE_TRACK_COMPRESSION', true),
];