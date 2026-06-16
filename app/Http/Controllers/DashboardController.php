<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Ditambahkan untuk men-generate string acak API KEY

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
     * TAMBAHAN: Menampilkan halaman form edit (Melihat detail data berita sebelum di-edit)
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        
        // Validasi Otoritas: Hanya penulis asli atau admin yang boleh masuk ke halaman edit
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $news->user_id) {
            return abort(403, 'Anda tidak memiliki izin untuk mengedit berita ini.');
        }

        return view('dashboard.edit', compact('news'));
    }

    /**
     * TAMBAHAN: Menyimpan perubahan data edit berita & menurunkan status kembali menjadi 'pending'
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        // Validasi Otoritas: Pastikan user berhak melakukan update
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $news->user_id) {
            return abort(403, 'Anda tidak memiliki izin untuk mengubah berita ini.');
        }

        $request->validate([
            'judul' => 'required|max:255',
            'isi_berita' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.max' => 'Ukuran foto maksimal adalah 2MB',
            'foto.image' => 'File yang diupload harus berupa gambar'
        ]);

        try {
            $news->title = $request->judul;
            $news->content = $request->isi_berita;
            
            // ATURAN ALUR: Kembalikan status menjadi pending agar wajib di-ACC Admin lagi
            $news->status = 'pending';

            // Jika kreator mengunggah file cover image baru
            if ($request->hasFile('foto')) {
                // Bersihkan/Hapus file gambar fisik yang lama agar tidak memenuhi local disk
                $path_foto_lama = public_path('berita/' . $news->image);
                if (File::exists($path_foto_lama) && !empty($news->image)) {
                    File::delete($path_foto_lama);
                }

                // Proses upload gambar baru
                $file = $request->file('foto');
                $nama_foto = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('berita'), $nama_foto);
                
                $news->image = $nama_foto;
            }

            $news->save();

            // Selesai, arahkan kembali ke dashboard utama dengan notifikasi flash message info
            return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui dan dikirim ulang untuk menunggu persetujuan Admin!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui data berita: ' . $e->getMessage()]);
        }
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

    /**
     * Menampilkan Halaman Profile & API Credentials
     */
    public function profile()
    {
        return view('dashboard.profile');
    }

    /**
     * Memperbarui Data Profil User (Nama, Email, Password)
     */
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

    /**
     * TAMBAHAN EAS: Men-generate atau memperbarui API KEY unik untuk User secara mandiri
     */
    public function generateApiKey(Request $request)
    {
        $user = Auth::user();
        
        // Menghasilkan string acak unik sepanjang 32 karakter dengan prefix 'news_'
        $user->api_key = 'news_' . Str::random(32);
        $user->save();

        return back()->with('success', 'API KEY baru berhasil dibuat! Silakan cek bagian bawah halaman.');
    }
}