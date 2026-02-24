<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Log;

class UserImageFavoriteController extends Controller
{
    public function toggle(Request $request, $imageId)
    {
        try {
            $user = $request->user();
            $image = Upload::findOrFail($imageId);

            // Cek apakah sudah di-like
            $isLiked = $user->favoriteImages()->where('image_id', $image->id)->exists();

            if ($isLiked) {
                // Unlike
                $user->favoriteImages()->detach($image->id);
                $message = 'Image removed from favorites';
                $liked = false;
            } else {
                // Like
                $user->favoriteImages()->attach($image->id);
                $message = 'Image added to favorites';
                $liked = true;
            }

            Log::info('Favorite toggled', [
                'user_id' => $user->id,
                'image_id' => $image->id,
                'action' => $liked ? 'liked' : 'unliked'
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'liked' => $liked,
                'total_likes' => $image->total_likes
            ]);

        } catch (\Exception $e) {
            Log::error('Favorite toggle failed', [
                'error' => $e->getMessage(),
                'image_id' => $imageId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle favorite'
            ], 500);
        }
    }

    public function like(Request $request, $imageId)
    {
        try {
            $user = $request->user();
            $image = Upload::findOrFail($imageId);

            $user->favoriteImages()->syncWithoutDetaching([$image->id]);

            return response()->json([
                'success' => true,
                'message' => 'Image liked successfully',
                'liked' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like image'
            ], 500);
        }
    }

    public function unlike(Request $request, $imageId)
    {
        try {
            $user = $request->user();
            $image = Upload::findOrFail($imageId);

            $user->favoriteImages()->detach($image->id);

            return response()->json([
                'success' => true,
                'message' => 'Image unliked successfully',
                'liked' => false
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unlike image'
            ], 500);
        }
    }
}