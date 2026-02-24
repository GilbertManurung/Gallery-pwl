<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua API dilindungi middleware check.valkey
| Route tertentu juga menggunakan auth:sanctum
|--------------------------------------------------------------------------
*/

Route::middleware(['api', 'check.valkey'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH ROUTES (PUBLIC)
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {

        // REGISTER
        Route::post('/register', function (Request $request) {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('api-token-' . now()->timestamp)->plainTextToken;

            return response()->json([
                'status'  => 'success',
                'message' => 'User registered successfully',
                'user'    => $user,
                'token'   => $token,
            ], 201);
        });

        // LOGIN
        Route::post('/login', function (Request $request) {
            $validated = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $token = $user->createToken('api-token-' . now()->timestamp)->plainTextToken;

            return response()->json([
                'status'  => 'success',
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token,
            ]);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES (AUTH + VAL_KEY)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // PROFILE
        Route::get('/profile', [ProfileController::class, 'show']);

        // contoh route lainnya
        // Route::post('/posts', [PostController::class, 'store']);
    });
});
