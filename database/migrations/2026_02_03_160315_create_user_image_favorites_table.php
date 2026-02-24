<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_image_favorites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('image_id');
            $table->timestamp('created_at')->useCurrent();

            // Composite Primary Key
            $table->primary(['user_id', 'image_id']);

            // Foreign Keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->cascadeOnDelete();

            // Index for fast image like count
            $table->index('image_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_image_favorites');
    }
};
