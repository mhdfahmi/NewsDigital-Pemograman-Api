<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaController; 
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/

// Halaman Home: Menampilkan hanya berita yang sudah di-ACC (Published)
Route::get('/', function () {
    $news = News::with('user')->where('status', 'published')->latest()->get();
    return view('home', compact('news'));
})->name('home');

// Halaman Detail Berita
Route::get('/berita/{id}', function ($id) {
    $item = News::with('user')->findOrFail($id);
    return view('detail', compact('item'));
})->name('berita.detail');

// Halaman Login & Register
Route::get('/login-page', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/dashboard');
    }
    return view('loginregister');
})->name('login');

// TAMBAHAN FITUR (EAS POIN 3): Halaman Landing Page Panduan / Dokumentasi API
Route::get('/dokumentasi', function () {
    return view('dokumentasi');
})->name('api.documentation');

// TAMBAHAN FITUR (EAS POIN 4): Halaman API Client Tester (Postman Web-Style Interface)
Route::get('/client-test', function () {
    return view('client_test');
})->name('api.client_test');


/*
|--------------------------------------------------------------------------
| 2. PROSES AUTHENTICATION (Login, Register, & Logout)
|--------------------------------------------------------------------------
*/

// Proses Login dengan deteksi Role
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($role === 'penulis') {
            return redirect('/dashboard');
        }
        
        return redirect('/');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

// Proses Register (Otomatis menjadi Penulis/Creator)
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

    Auth::login($user);
    return redirect('/dashboard');
});

// Proses Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


/*
|--------------------------------------------------------------------------
| 3. HALAMAN DASHBOARD & ACTION (Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Menambahkan rute fallback dashboard agar link di Navigasi tidak error
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('penulis.dashboard');
    })->name('dashboard');

    // --- GRUP KHUSUS ADMIN ---
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
        Route::post('/approve/{id}', [DashboardController::class, 'approve'])->name('berita.approve');
    });

    // --- GRUP KHUSUS PENULIS (CREATOR) ---
    Route::middleware(['penulis'])->group(function () {
        Route::get('/creator/dashboard', [DashboardController::class, 'index'])->name('penulis.dashboard');
        Route::post('/berita/store', [DashboardController::class, 'store'])->name('berita.store');
    });

    // --- FITUR UMUM ---
    Route::delete('/berita/{id}', [DashboardController::class, 'destroy'])->name('berita.destroy');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // TAMBAHAN FITUR: Route View sebelum Edit & Proses Simpan Koreksi Berita
    Route::get('/berita/{id}/edit', [DashboardController::class, 'edit'])->name('berita.edit');
    Route::post('/berita/{id}/update', [DashboardController::class, 'update'])->name('berita.update');

    // --- TAMBAHAN FITUR API KEY (EAS POIN 1) ---
    // Proses pembuatan / generate ulang API KEY unik via halaman Profile
    Route::post('/profile/generate-api-key', [DashboardController::class, 'generateApiKey'])->name('profile.generate_key');

});