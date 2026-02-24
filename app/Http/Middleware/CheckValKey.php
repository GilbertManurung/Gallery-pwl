<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckValKey
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini hanya memverifikasi header VAL_KEY
     * dengan yang ada di file .env. 
     * VAL_KEY TIDAK TERKAIT ke user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 1️⃣ Jika request bukan JSON (misal request web biasa), lewati
        if (!$request->expectsJson()) {
            return $next($request);
        }

        // 2️⃣ Ambil VAL_KEY dari header
        $valKeyHeader = $request->header('VAL_KEY');

        // 3️⃣ Cocokkan VAL_KEY dengan yang ada di .env
        if (!$valKeyHeader || $valKeyHeader !== env('VAL_KEY')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid VAL_KEY'
            ], 403);
        }

        // 4️⃣ Lanjutkan request ke route berikutnya
        return $next($request);
    }
}
