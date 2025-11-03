<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('webp_path')->nullable()->after('path');
            $table->json('thumbnails')->nullable()->after('webp_path');
            $table->boolean('is_optimized')->default(false)->after('thumbnails');
            $table->integer('original_size')->nullable()->after('is_optimized');
            $table->integer('optimized_size')->nullable()->after('original_size');
            $table->string('optimization_quality')->nullable()->after('optimized_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn([
                'webp_path',
                'thumbnails',
                'is_optimized',
                'original_size',
                'optimized_size',
                'optimization_quality'
            ]);
        });
    }
};