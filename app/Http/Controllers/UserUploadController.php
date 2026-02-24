<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserUploadController extends Controller
{
    /**
     * Tampilkan form create/upload.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Simpan file ke MinIO sesuai bucket dan simpan info ke database.
     */
    public function store(Request $request)
    {
        // 1️⃣ Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|in:aesthetic,sport',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp|max:10240', // max 10MB
        ]);

        $user = Auth::user();
        $file = $request->file('file');

        // 2️⃣ Generate nama file unik agar tidak bentrok
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

        // 3️⃣ Pilih disk MinIO sesuai topic/bucket
        $disk = $request->topic; // 'aesthetic' atau 'sport'

        // 4️⃣ Upload file ke MinIO
        $filePath = Storage::disk($disk)->putFileAs('', $file, $filename);

        // 5️⃣ Simpan info upload ke database
        $upload = Upload::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'topic' => $request->topic,
            'file_path' => $filePath,
        ]);

        // 6️⃣ Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'File berhasil diupload!');
    }

    /**
     * Hapus gambar dari storage MinIO dan database.
     */
    public function destroy($id)
    {
        try {
            // 1️⃣ Cari upload berdasarkan ID
            $upload = Upload::findOrFail($id);

            // 2️⃣ Pastikan hanya pemilik yang bisa menghapus
            if ($upload->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus gambar ini.'
                ], 403);
            }

            // 3️⃣ Hapus file dari MinIO storage
            $disk = $upload->topic; // 'aesthetic' atau 'sport'
            if (Storage::disk($disk)->exists($upload->file_path)) {
                Storage::disk($disk)->delete($upload->file_path);
            }

            // 4️⃣ Hapus record dari database
            $upload->delete();

            // 5️⃣ Return response sukses
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
}