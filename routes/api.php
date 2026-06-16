<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BeritaController; // <-- 1. WAJIB ADA BARIS INI UNTUK MENGHUBUNGKAN KE CONTROLLER

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Akses Tanpa API KEY)
|--------------------------------------------------------------------------
*/

// Registrasi User Baru via API
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    // Membuat string random 16 karakter untuk API Key otomatis saat daftar
    $generatedApiKey = bin2hex(random_bytes(8)); 

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'penulis', 
        'api_key' => $generatedApiKey,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Registrasi Berhasil! Silakan catat API Key Anda.',
        'api_key' => $user->api_key,
        'user' => $user
    ], 201);
});

// Login via API untuk mendapatkan API KEY
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'Login Berhasil!',
            'api_key' => $user->api_key,
            'user' => $user
        ], 200);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Email atau Password salah.'
    ], 401);
});


/*
|--------------------------------------------------------------------------
| 2. RUTE TERPROTEKSI (Wajib Menggunakan x-api-key di Headers via Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['api_key'])->group(function () {

    // =========================================================================
    // --- 2. FITUR CRUD BERITA (Sekarang Pendek Karena Memanggil BeritaController) ---
    // =========================================================================

    Route::get('/berita', [BeritaController::class, 'indexApi']);
    Route::post('/berita', [BeritaController::class, 'storeApi']);
    Route::put('/berita/{id}', [BeritaController::class, 'updateApi']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroyApi']);
    

    // =========================================================================
    // --- 3. FITUR CRUD USER (Tetap Di Sini Menggunakan Fungsi Manual) ---
    // =========================================================================

    // [GET ALL] Mengambil Semua Data User
    Route::get('/users', function () {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'total_user' => $users->count(),
            'data' => $users
        ], 200);
    });

    // [PUT] Update Data User via API
    Route::put('/users/{id}', function (Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'email' => 'sometimes|email|unique:users,email,' . $id,
        ]);

        // Jika password diisi, lakukan hashing otomatis sebelum update
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        $user->update($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diperbarui!',
            'data' => $user
        ], 200);
    });

    // [DELETE] Hapus User via API
    Route::delete('/users/{id}', function ($id) {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus dari database.'
        ], 200);
    });

});