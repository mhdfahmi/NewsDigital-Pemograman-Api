<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // Helper untuk memvalidasi API Key
    private function validateApiKey(Request $request) {
        $apiKey = $request->header('x-api-key');
        
        // Cek apakah key ada dan valid di tabel users
        $user = User::where('api_key', $apiKey)->first();
        
        return $user;
    }

    // --- KHUSUS HALAMAN WEB ---
    public function index() {
        $berita = News::latest()->get();
        return view('home', compact('berita'));
    }

    // --- KHUSUS ENDPOINT API ---
    
    // Get All Api (Publik - tanpa API Key pun bisa)
    public function indexApi() {
        $berita = News::with('user')->latest()->get();
        return response()->json([
            'status' => 'success',
            'total' => $berita->count(),
            'data' => $berita
        ], 200);
    }

    // Store Api (Memerlukan API Key)
    public function storeApi(Request $request) {
        if (!$this->validateApiKey($request)) {
            return response()->json(['status' => 'error', 'message' => 'API Key Tidak Valid!'], 401);
        }

        $request->validate([
            'title' => 'required|string',
            'content' => 'required',
            'kategori' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $nama_foto = 'default.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $nama_foto = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('berita'), $nama_foto);
        }

        $berita = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'kategori' => $request->kategori,
            'user_id' => $request->user_id,
            'status' => 'published',
            'image' => $nama_foto
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berita berhasil dibuat!', 'data' => $berita], 201);
    }

    // Update Api (Memerlukan API Key)
    public function updateApi(Request $request, $id) {
        if (!$this->validateApiKey($request)) {
            return response()->json(['status' => 'error', 'message' => 'API Key Tidak Valid!'], 401);
        }

        $berita = News::findOrFail($id);
        $berita->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Berita berhasil diupdate!', 'data' => $berita], 200);
    }

    // Destroy Api (Memerlukan API Key)
    public function destroyApi(Request $request, $id) {
        if (!$this->validateApiKey($request)) {
            return response()->json(['status' => 'error', 'message' => 'API Key Tidak Valid!'], 401);
        }

        $berita = News::findOrFail($id);
        if ($berita->image && $berita->image != 'default.jpg' && file_exists(public_path('berita/' . $berita->image))) {
            @unlink(public_path('berita/' . $berita->image));
        }
        $berita->delete();
        return response()->json(['status' => 'success', 'message' => 'Berita berhasil dihapus.'], 200);
    }
}