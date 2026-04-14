<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes - File: routes/api.php
|--------------------------------------------------------------------------
| File ini menangani semua request dari Thunder Client / Postman.
| Secara otomatis memiliki prefix /api (Contoh: http://127.0.0.1:8000/api/login)
*/

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Akses Tanpa API KEY)
|--------------------------------------------------------------------------
*/

// Registrasi User Baru (Otomatis Role Penulis)
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'penulis', 
    ]);

    return response()->json([
        'message' => 'Registrasi Berhasil!',
        'user' => $user
    ], 201);
});

// Login untuk mendapatkan API KEY
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'message' => 'Login Berhasil!',
            'api_key' => $user->api_key, // Menampilkan API Key dari database
            'user' => $user
        ]);
    }

    return response()->json(['message' => 'Email atau Password salah.'], 401);
});


/*
|--------------------------------------------------------------------------
| 2. RUTE TERPROTEKSI (Wajib Menggunakan x-api-key di Headers)
|--------------------------------------------------------------------------
*/

Route::middleware(['api_key'])->group(function () {

    // --- FITUR BERITA ---

    // Get All Berita
    Route::get('/berita', function () {
        $news = News::with('user')->get();
        return response()->json([
            'status' => 'success',
            'data' => $news
        ]);
    });

    // Update Berita (PUT)
    Route::put('/berita/{id}', function (Request $request, $id) {
        $berita = News::findOrFail($id);
        $berita->update($request->all());
        
        return response()->json([
            'message' => 'Berita berhasil diupdate!',
            'data' => $berita
        ]);
    });


    // Delete Berita (DELETE)
    Route::delete('/berita/{id}', function ($id) {
        $berita = News::findOrFail($id);
        $berita->delete();
        
        return response()->json(['message' => 'Berita berhasil dihapus.']);
    });
    
    // Tambah Berita Baru (POST)
    Route::post('/berita', function (Request $request) {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $berita = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'status' => 'published', // Set otomatis published agar langsung muncul di home
            'image' => 'default.jpg' // Placeholder jika sistem Anda wajib ada kolom image
        ]);

        return response()->json([
            'message' => 'Berita berhasil ditambahkan!',
            'data' => $berita
        ], 201);
    });


    // --- FITUR USER ---

    // Get All Data Users
    Route::get('/users', function () {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'total_user' => $users->count(),
            'data' => $users
        ]);
    });

    /**
     * PERBAIKAN & TAMBAHAN:
     * Menambahkan fitur Update dan Delete User melalui API
     */

    // Update User (PUT)
    Route::put('/users/{id}', function (Request $request, $id) {
        $user = User::findOrFail($id);
        
        // Validasi opsional agar email tetap unik saat update
        $request->validate([
            'email' => 'sometimes|email|unique:users,email,' . $id,
        ]);

        $user->update($request->all());

        return response()->json([
            'message' => 'User berhasil diupdate!',
            'data' => $user
        ]);
    });

    // Delete User (DELETE)
    Route::delete('/users/{id}', function ($id) {
        $user = User::findOrFail($id);
        
        // Mencegah menghapus diri sendiri jika sedang login (opsional)
        // if (Auth::id() == $id) {
        //     return response()->json(['message' => 'Tidak bisa menghapus akun sendiri!'], 403);
        // }

        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus.']);
    });

});