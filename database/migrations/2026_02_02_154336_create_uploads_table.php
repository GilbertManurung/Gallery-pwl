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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();

            // User yang upload
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Judul file / post
            $table->string('title');

            // Bucket MinIO (aesthetic / sport)
            $table->enum('topic', ['aesthetic', 'sport'])
                  ->index();

            // Nama file di MinIO (uuid.ext)
            $table->string('file_path');

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
