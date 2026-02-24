<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Tampilkan data user yang sedang login (protected route)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'User profile retrieved successfully',
            'user'    => $request->user(), // data user dari token Sanctum
        ]);
    }
}
