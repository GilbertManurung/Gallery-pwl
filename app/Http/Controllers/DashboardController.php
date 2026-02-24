<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // ✅ TAMPILKAN SEMUA UPLOAD (PUBLIC) dengan relasi user
        $uploads = Upload::with('user')
            ->latest()
            ->get();

        // Tambahkan informasi apakah user sudah like setiap gambar
        $uploads->each(function ($upload) use ($user) {
            $upload->is_liked_by_current_user = $upload->isLikedBy($user->id);
        });

        // Debug: Log URL yang dihasilkan
        foreach ($uploads as $upload) {
            Log::debug('Upload Image URL', [
                'id' => $upload->id,
                'title' => $upload->title,
                'topic' => $upload->topic,
                'file_path' => $upload->file_path,
                'image_url' => $upload->image_url,
                'uploader' => $upload->user->name ?? 'Unknown',
                'is_liked' => $upload->is_liked_by_current_user
            ]);
        }

        return view('dashboard.dashboard', compact('uploads'));
    }

    public function create()
    {
        return view('dashboard.create');
    }

    public function store(Request $request)
    {
        // LOG HIT
        Log::debug('STORE UPLOAD HIT', [
            'user_id'  => Auth::id(),
            'has_file' => $request->hasFile('file'),
            'all'      => $request->except('file'),
        ]);

        // VALIDASI
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|in:aesthetic,sport',
            'file'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // ⬆️ UPLOAD KE BUCKET SESUAI TOPIC dengan visibility public
            $path = Storage::disk($validated['topic'])->putFileAs(
                '/',
                $file,
                $filename,
                'public'
            );

            // Log untuk debugging - cek apakah file benar-benar terupload
            $exists = Storage::disk($validated['topic'])->exists($filename);
            
            Log::info('File uploaded', [
                'disk' => $validated['topic'],
                'path' => $path,
                'filename' => $filename,
                'exists' => $exists,
                'url' => Storage::disk($validated['topic'])->url($filename)
            ]);

            // ⬆️ SIMPAN DB
            $upload = Upload::create([
                'user_id'   => Auth::id(),
                'title'     => $validated['title'],
                'topic'     => $validated['topic'],
                'file_path' => $filename,
            ]);

            // Log URL yang akan digunakan
            Log::info('Generated Image URL', [
                'upload_id' => $upload->id,
                'image_url' => $upload->image_url
            ]);

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('success', 'File berhasil diupload 🎉');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('UPLOAD FAILED', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }

    public function collection()
    {
        $user = Auth::user();
        
        // ✅ TAMPILKAN HANYA UPLOAD MILIK USER YANG LOGIN (PRIVATE)
        $myUploads = Upload::where('user_id', $user->id)
            ->latest()
            ->get();

        // ✅ TAMPILKAN GAMBAR YANG DI-FAVORITE USER
        $myFavorites = $user->favoriteImages()
            ->with('user')
            ->get();

        return view('dashboard.collection', compact('myUploads', 'myFavorites'));
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return back()->with('success', 'Settings berhasil diperbarui.');
    }

    /**
     * Download gambar dengan nama file yang sesuai
     */
    public function download($uploadId)
    {
        try {
            $upload = Upload::findOrFail($uploadId);

            // Pastikan file ada di storage
            $disk = $upload->topic; // 'aesthetic' atau 'sport'
            $filename = $upload->file_path;

            if (!Storage::disk($disk)->exists($filename)) {
                Log::error('File not found for download', [
                    'upload_id' => $uploadId,
                    'disk' => $disk,
                    'filename' => $filename
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }

            // Generate nama file untuk download
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $downloadName = Str::slug($upload->title) . '_by_' . Str::slug($upload->user->name) . '.' . $extension;

            // Download file
            return Storage::disk($disk)->download($filename, $downloadName);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Upload not found', ['upload_id' => $uploadId]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);

        } catch (\Throwable $e) {
            Log::error('Download error', [
                'upload_id' => $uploadId,
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh gambar'
            ], 500);
        }
    }
}
