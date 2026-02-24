<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserImageFavorite extends Pivot
{
    /**
     * Nama tabel
     */
    protected $table = 'user_image_favorites';

    /**
     * Kolom yang bisa diisi massal
     */
    protected $fillable = ['user_id', 'image_id'];

    /**
     * Disable timestamps (hanya ada created_at)
     */
    public $timestamps = false;

    /**
     * Tidak ada updated_at
     */
    const UPDATED_AT = null;

    /**
     * Cast attributes
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
}