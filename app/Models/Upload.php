<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi massal
     */
    protected $fillable = [
        'user_id',
        'title',
        'topic',
        'file_path',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ========================================
     * RELASI
     * ========================================
     */

    /**
     * Relasi ke User (uploader)
     * Upload belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke users yang menyukai gambar ini
     * Upload has many Users through pivot table
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_image_favorites', 'image_id', 'user_id')
            ->withPivot('created_at')
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * ========================================
     * ACCESSORS
     * ========================================
     */

    /**
     * Accessor untuk mendapatkan URL gambar
     * Diakses dengan: $upload->image_url
     */
    public function getImageUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        // Disk berdasarkan topic (aesthetic atau sport)
        $disk = $this->topic;

        try {
            // Cek apakah file ada
            if (Storage::disk($disk)->exists($this->file_path)) {
                return Storage::disk($disk)->url($this->file_path);
            }
        } catch (\Exception $e) {
            \Log::error('Error generating image URL', [
                'upload_id' => $this->id,
                'file_path' => $this->file_path,
                'disk' => $disk,
                'error' => $e->getMessage()
            ]);
        }

        // Fallback: return placeholder atau null
        return null;
    }

    /**
     * Accessor untuk mendapatkan total likes
     * Diakses dengan: $upload->total_likes
     */
    public function getTotalLikesAttribute()
    {
        return $this->favoritedByUsers()->count();
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Cek apakah gambar ini sudah di-like oleh user tertentu
     * 
     * @param int $userId
     * @return bool
     */
    public function isLikedBy($userId)
    {
        return $this->favoritedByUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Cek apakah gambar ini milik user tertentu
     * 
     * @param int $userId
     * @return bool
     */
    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }

    /**
     * Toggle like/unlike oleh user tertentu
     * 
     * @param int $userId
     * @return bool true jika liked, false jika unliked
     */
    public function toggleLike($userId)
    {
        $exists = $this->favoritedByUsers()->where('user_id', $userId)->exists();
        
        if ($exists) {
            $this->favoritedByUsers()->detach($userId);
            return false; // unliked
        } else {
            $this->favoritedByUsers()->attach($userId);
            return true; // liked
        }
    }

    /**
     * ========================================
     * SCOPES
     * ========================================
     */

    /**
     * Scope untuk filter berdasarkan topic
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $topic
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTopic($query, $topic)
    {
        return $query->where('topic', $topic);
    }

    /**
     * Scope untuk mendapatkan upload terpopuler (paling banyak likes)
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('favoritedByUsers')
            ->orderBy('favorited_by_users_count', 'desc')
            ->limit($limit);
    }

    /**
     * Scope untuk mendapatkan upload terbaru
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}