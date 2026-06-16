<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // --- KHUSUS HALAMAN WEB ---
    public function index() {
        $berita = News::latest()->get();
        return view('home', compact('berita'));
    }

    // --- KHUSUS ENDPOINT API POSTMAN/THUNDER CLIENT ---
    
    // Get All Api
    public function indexApi() {
        $berita = News::with('user')->latest()->get();
        return response()->json([
            'status' => 'success',
            'total' => $berita->count(),
            'data' => $berita
        ], 200);
    }

    // Store Api
    public function storeApi(Request $request) {
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

    // Update Api
    public function updateApi(Request $request, $id) {
        $berita = News::findOrFail($id);
        $berita->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Berita berhasil diupdate!', 'data' => $berita], 200);
    }

    // Destroy Api
    public function destroyApi($id) {
        $berita = News::findOrFail($id);
        if ($berita->image && $berita->image != 'default.jpg' && file_exists(public_path('berita/' . $berita->image))) {
            @unlink(public_path('berita/' . $berita->image));
        }
        $berita->delete();
        return response()->json(['status' => 'success', 'message' => 'Berita berhasil dihapus.'], 200);
    }
}