<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StorageService
{
    /**
     * Upload file ke bucket tertentu di MinIO.
     *
     * @param UploadedFile|string $file Path lokal atau UploadedFile
     * @param string $bucket Nama bucket ('sport' | 'aesthetic')
     * @param string|null $filename Nama file yang ingin disimpan, optional
     * @return string|null URL file jika berhasil, null jika gagal
     */
    public static function uploadToBucket($file, string $bucket, ?string $filename = null): ?string
    {
        // Validasi bucket
        $allowedBuckets = ['sport', 'aesthetic'];
        if (!in_array($bucket, $allowedBuckets)) {
            throw new \InvalidArgumentException("Bucket '$bucket' tidak tersedia.");
        }

        // Jika filename tidak diberikan, ambil nama asli file
        if (!$filename) {
            $filename = $file instanceof UploadedFile ? $file->getClientOriginalName() : basename($file);
        }

        // Path di bucket
        $path = $filename;

        // Upload ke disk minio
        $success = Storage::disk('minio')->putFileAs($bucket, $file, $filename);

        if ($success) {
            // Generate public URL
            return Storage::disk('minio')->url($path);
        }

        return null;
    }
}
