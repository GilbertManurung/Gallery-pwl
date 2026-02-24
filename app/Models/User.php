<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Attributes yang bisa diisi massal
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'valkey', // hanya jika kolom ini ada di DB
    ];

    /**
     * Attributes yang disembunyikan saat serialisasi
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes ke tipe tertentu
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator untuk otomatis hash password
     */
    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = Hash::needsRehash($password)
                ? Hash::make($password)
                : $password;
        }
    }

    /**
     * ========================================
     * RELASI UNTUK FITUR FAVORIT
     * ========================================
     */

    /**
     * Relasi ke gambar-gambar yang diupload oleh user ini
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    /**
     * Relasi ke gambar-gambar yang difavoritkan oleh user ini
     * Menggunakan pivot table user_image_favorites
     */
    public function favoriteImages()
    {
        return $this->belongsToMany(Upload::class, 'user_image_favorites', 'user_id', 'image_id')
            ->withPivot('created_at')
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * Helper method untuk cek apakah user sudah like gambar tertentu
     * 
     * @param int $imageId
     * @return bool
     */
    public function hasLiked($imageId)
    {
        return $this->favoriteImages()->where('image_id', $imageId)->exists();
    }

    /**
     * Helper method untuk toggle like/unlike gambar
     * 
     * @param int $imageId
     * @return bool true jika liked, false jika unliked
     */
    public function toggleFavorite($imageId)
    {
        $exists = $this->favoriteImages()->where('image_id', $imageId)->exists();
        
        if ($exists) {
            $this->favoriteImages()->detach($imageId);
            return false; // unliked
        } else {
            $this->favoriteImages()->attach($imageId);
            return true; // liked
        }
    }
}