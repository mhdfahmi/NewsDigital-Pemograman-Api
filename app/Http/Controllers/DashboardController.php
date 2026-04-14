<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk PENULIS/CREATOR
     */
    public function index()
    {
        $user = Auth::user();
        
        // SINKRON: Menggunakan 'user_id' sesuai gambar database news Anda
        $myNews = News::where('user_id', $user->id)->latest()->get();
        $countMyNews = $myNews->count();
        
        // Variabel kosong agar view admin/penulis yang bercampur tidak error
        $news = collect();
        $totalNews = $countMyNews;

        return view('dashboard.penulis', compact('myNews', 'countMyNews', 'news', 'totalNews'));
    }

    /**
     * Dashboard untuk ADMIN
     */
    public function adminIndex()
    {
        $user = Auth::user();
        
        // Admin melihat semua berita
        $news = News::latest()->get();
        $totalNews = News::count();
        $totalUser = User::count();
        
        $myNews = collect(); 
        $countMyNews = 0;

        return view('dashboard.admin', compact('news', 'totalNews', 'totalUser', 'myNews', 'countMyNews'));
    }

    /**
     * Menyimpan berita baru (SINKRON dengan kolom database: title, content, image, user_id)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi_berita' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.max' => 'Ukuran foto maksimal adalah 2MB',
            'foto.image' => 'File yang diupload harus berupa gambar'
        ]);

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Bersihkan nama file
                $extension = $file->getClientOriginalExtension();
                $nama_foto = time() . '_' . uniqid() . '.' . $extension;

                // Tentukan folder tujuan di PUBLIC
                $tujuan_upload = public_path('berita');

                if (!File::exists($tujuan_upload)) {
                    File::makeDirectory($tujuan_upload, 0777, true, true);
                }

                $file->move($tujuan_upload, $nama_foto);

                // SINKRON: Menggunakan nama kolom asli di tabel 'news' Anda
                News::create([
                    'title'    => $request->judul,      // Input 'judul' simpan ke kolom 'title'
                    'content'  => $request->isi_berita, // Input 'isi_berita' simpan ke kolom 'content'
                    'image'    => $nama_foto,           // Hasil upload simpan ke kolom 'image'
                    'user_id'  => Auth::user()->id,     // Simpan ID User ke kolom 'user_id'
                    'status'   => 'pending', 
                ]);

                return back()->with('success', 'Berita berhasil dikirim dan menunggu moderasi Admin!');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Admin menyetujui berita
     */
    public function approve($id)
    {
        $news = News::findOrFail($id);
        $news->status = 'published';
        $news->save();

        return back()->with('success', 'Berita telah dipublikasikan!');
    }

    /**
     * Menghapus berita dan file fisiknya
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $user = Auth::user();
        
        // SINKRON: Cek otoritas berdasarkan user_id di tabel news
        if ($user->role === 'admin' || $user->id === $news->user_id) {
            
            $path_foto = public_path('berita/' . $news->image);
            if (File::exists($path_foto)) {
                File::delete($path_foto);
            }

            $news->delete();
            return back()->with('success', 'Berita berhasil dihapus.');
        }

        return abort(403, 'Anda tidak memiliki izin.');
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}