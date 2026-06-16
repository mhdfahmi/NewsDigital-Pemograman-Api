<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <nav class="bg-white/80 backdrop-blur-md border-b sticky top-0 z-50 px-6 md:px-10 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-black text-2xl text-indigo-600 tracking-tight">
            <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
            </div>
            News<span class="text-slate-900">Digital</span> <span class="text-[10px] bg-indigo-100 text-indigo-600 px-2 py-1 rounded-md font-bold uppercase ml-1">API Docs</span>
        </a>
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
            </a>
            @auth
                <a href="{{ route('profile') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-900 transition-all shadow-md shadow-indigo-100">Dashboard</a>
            @else
                <a href="{{ url('/login-page') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-900 transition-all shadow-md shadow-indigo-100">Daftar & Ambil API Key</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <aside class="lg:col-span-1 space-y-2 sticky top-24 h-fit hidden lg:block">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 mb-4">Memulai (*Getting Started*)</p>
            <a href="#pengantar" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all flex items-center gap-2">
                <i data-lucide="rocket" class="w-4 h-4 text-indigo-600"></i> Pengantar
            </a>
            <a href="#autentikasi" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all flex items-center gap-2">
                <i data-lucide="key-round" class="w-4 h-4 text-amber-500"></i> Autentikasi & API Key
            </a>
            
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 pt-6 mb-4">Referensi Endpoint</p>
            <a href="#get-all" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors flex items-center gap-2">
                <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.5 rounded font-bold">GET</span> Berita Terkini
            </a>
            <a href="#get-detail" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors flex items-center gap-2">
                <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.5 rounded font-bold">GET</span> Detail Berita
            </a>
            <a href="#post-news" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors flex items-center gap-2">
                <span class="text-[9px] bg-blue-500 text-white px-1.5 py-0.5 rounded font-bold">POST</span> Tulis Berita
            </a>
            <a href="#delete-news" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors flex items-center gap-2">
                <span class="text-[9px] bg-rose-500 text-white px-1.5 py-0.5 rounded font-bold">DEL</span> Hapus Berita
            </a>
        </aside>

        <main class="lg:col-span-3 space-y-12">
            
            <section id="pengantar" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dokumentasi Integrasi API NewsDigital</h1>
                    <p class="text-slate-600 leading-relaxed">
                        Selamat datang di API resmi <strong>NewsDigital Portal</strong>. API ini dirancang menggunakan standar arsitektur RESTful yang aman untuk mendistribusikan, memuat, menerbitkan, hingga menghapus data artikel berita secara <em>real-time</em> dari database utama kami ke aplikasi eksternal Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50 flex gap-4 items-start">
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl"><i data-lucide="layout-grid" class="w-5 h-5"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">4 Endpoint RESTful</h4>
                            <p class="text-xs text-slate-500 mt-1">Mendukung fungsionalitas CRUD penuh untuk integrasi distribusi berita.</p>
                        </div>
                    </div>
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50 flex gap-4 items-start">
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl"><i data-lucide="shield-check" class="w-5 h-5"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Proteksi API Key</h4>
                            <p class="text-xs text-slate-500 mt-1">Setiap akun kreator dibekali token unik untuk mengamankan hak akses modifikasi.</p>
                        </div>
                    </div>
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50 flex gap-4 items-start">
                        <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl"><i data-lucide="code-2" class="w-5 h-5"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Output JSON Standar</h4>
                            <p class="text-xs text-slate-500 mt-1">Struktur payload response ringan dan mudah di-parsing di berbagai platform.</p>
                        </div>
                    </div>
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50 flex gap-4 items-start">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl"><i data-lucide="image" class="w-5 h-5"></i></div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Multipart Media Upload</h4>
                            <p class="text-xs text-slate-500 mt-1">Mendukung pengiriman berkas gambar cover berita langsung via API request.</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-indigo-50/40 rounded-2xl border border-indigo-100 flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <p class="text-[10px] font-black text-indigo-600 uppercase tracking-wider mb-0.5">Base URL API Sistem:</p>
                        <code class="text-sm font-bold text-slate-800 break-all">http://127.0.0.1:8000/api</code>
                    </div>
                    <span class="text-xs bg-indigo-600 text-white font-bold px-3 py-1 rounded-full uppercase">Production</span>
                </div>
            </section>

            <section id="autentikasi" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3 text-slate-900">
                    <div class="p-2 bg-amber-100 text-amber-600 rounded-xl">
                        <i data-lucide="key-round" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight">Mekanisme Kredensial & Autentikasi</h2>
                </div>
                <p class="text-slate-600 leading-relaxed text-sm">
                    Setiap request HTTP (terutama metode <code>POST</code> dan <code>DELETE</code>) wajib menyertakan kredensial berupa token <strong>API KEY</strong> unik. Jika token tidak valid atau tidak disertakan, server akan menolak akses dengan respons kode status <code class="text-rose-600 font-bold">401 Unauthorized</code>.
                </p>
                <div class="space-y-2">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Penyisipan Via HTTP Request Header:</p>
                    <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs overflow-x-auto shadow-inner leading-relaxed">
<span class="text-indigo-400">Authorization</span>: Bearer <span class="text-amber-400">ganti_dengan_api_key_anda_disini</span>
<span class="text-indigo-400">Accept</span>: application/json</pre>
                </div>
                <div class="bg-amber-50 border border-amber-100 text-amber-800 p-5 rounded-2xl text-xs flex gap-3 leading-relaxed">
                    <i data-lucide="info" class="w-5 h-5 shrink-0 text-amber-500"></i>
                    <span><strong>Cara Mendapatkan API Key:</strong> Masuk atau daftarkan akun baru Anda melalui tombol di pojok kanan atas, navigasi ke halaman pengaturan profil Anda, lalu klik tombol <strong>Generate API Key</strong> untuk menyalin token enkripsi unik Anda.</span>
                </div>
            </section>

            <section id="get-all" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="bg-emerald-500 text-white text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">GET</span>
                        <h3 class="text-xl font-bold text-slate-900">Mengambil Seluruh Berita</h3>
                    </div>
                    <code class="text-xs bg-slate-100 text-slate-700 font-bold px-3 py-1.5 rounded-lg">/berita</code>
                </div>
                <p class="text-slate-600 text-sm">Endpoint publik untuk menarik semua data artikel berita yang statusnya sudah diterbitkan (<em>published</em>).</p>
                
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest pt-2">JSON Response Sukses (200 OK):</p>
                <pre class="bg-slate-900 text-emerald-400 p-5 rounded-2xl text-xs overflow-x-auto shadow-inner">
{
    "status": "success",
    "total": 1,
    "data": [
        {
            "id": 3,
            "title": "Evolusi AI di Tahun 2026",
            "kategori": "Teknologi",
            "isi_berita": "Kecerdasan buatan berkembang sangat pesat...",
            "image": "http://127.0.0.1:8000/berita/171854129.jpg",
            "created_at": "2026-06-16T06:00:00.000000Z"
        }
    ]
}</pre>
            </section>

            <section id="get-detail" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="bg-emerald-500 text-white text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">GET</span>
                        <h3 class="text-xl font-bold text-slate-900">Mengambil Detail Berita Spesifik</h3>
                    </div>
                    <code class="text-xs bg-slate-100 text-slate-700 font-bold px-3 py-1.5 rounded-lg">/berita/{id}</code>
                </div>
                <p class="text-slate-600 text-sm">Mengembalikan informasi lengkap dari satu artikel berita secara terperinci berdasarkan parameter ID unik.</p>

                <p class="text-xs font-black text-slate-400 uppercase tracking-widest pt-2">JSON Response Gagal (404 Not Found):</p>
                <pre class="bg-slate-900 text-rose-400 p-5 rounded-2xl text-xs overflow-x-auto shadow-inner">
{
    "status": "error",
    "message": "Artikel berita dengan ID tersebut tidak ditemukan di database."
}</pre>
            </section>

            <section id="post-news" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="bg-blue-500 text-white text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">POST</span>
                        <h3 class="text-xl font-bold text-slate-900">Membuat Berita Baru</h3>
                    </div>
                    <code class="text-xs bg-slate-100 text-slate-700 font-bold px-3 py-1.5 rounded-lg">/berita</code>
                </div>
                <p class="text-slate-600 text-sm mb-4">Mengirimkan data artikel berita baru ke database pusat. Memerlukan autentikasi API Key dan pengiriman tipe konten berupa <code>multipart/form-data</code> karena mendukung unggah berkas gambar.</p>
                
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Struktur Payload Body Data:</p>
                <div class="overflow-x-auto text-xs border rounded-2xl">
                    <table class="w-full text-left divide-y border-collapse">
                        <thead class="bg-slate-50 font-bold text-slate-700">
                            <tr>
                                <th class="p-3.5">Key Field</th>
                                <th class="p-3.5">Tipe Data</th>
                                <th class="p-3.5">Aturan / Validasi</th>
                                <th class="p-3.5">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-slate-600">
                            <tr>
                                <td class="p-3.5 font-bold text-slate-800">judul</td>
                                <td class="p-3.5 text-blue-600 font-medium">string</td>
                                <td class="p-3.5"><span class="bg-rose-50 text-rose-600 px-2 py-0.5 rounded font-bold">Required</span>, min:5</td>
                                <td class="p-3.5">Judul utama artikel berita yang akan dibuat.</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 font-bold text-slate-800">kategori</td>
                                <td class="p-3.5 text-blue-600 font-medium">string</td>
                                <td class="p-3.5"><span class="bg-rose-50 text-rose-600 px-2 py-0.5 rounded font-bold">Required</span></td>
                                <td class="p-3.5">Opsi kategori: <em>Teknologi, Hiburan, Olahraga, Bisnis</em>.</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 font-bold text-slate-800">foto</td>
                                <td class="p-3.5 text-blue-600 font-medium">file (binary)</td>
                                <td class="p-3.5"><span class="bg-rose-50 text-rose-600 px-2 py-0.5 rounded font-bold">Required</span>, max:2048KB</td>
                                <td class="p-3.5">Cover gambar artikel. Ekstensi diizinkan: <em>jpeg, png, jpg</em>.</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 font-bold text-slate-800">isi_berita</td>
                                <td class="p-3.5 text-blue-600 font-medium">text</td>
                                <td class="p-3.5"><span class="bg-rose-50 text-rose-600 px-2 py-0.5 rounded font-bold">Required</span></td>
                                <td class="p-3.5">Rangkaian paragraf konten utama dari berita.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-xs font-black text-slate-400 uppercase tracking-widest pt-2">JSON Response Sukses (201 Created):</p>
                <pre class="bg-slate-900 text-emerald-400 p-5 rounded-2xl text-xs overflow-x-auto shadow-inner">
{
    "status": "success",
    "message": "Artikel berita berhasil diajukan dan sedang menunggu moderasi/approve Admin.",
    "data": {
        "id": 4,
        "title": "Inovasi Cloud Computing Terkini",
        "kategori": "Teknologi",
        "status": "pending"
    }
}</pre>
            </section>

            <section id="delete-news" class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="bg-rose-500 text-white text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">DELETE</span>
                        <h3 class="text-xl font-bold text-slate-900">Menghapus Artikel Berita</h3>
                    </div>
                    <code class="text-xs bg-slate-100 text-slate-700 font-bold px-3 py-1.5 rounded-lg">/berita/{id}</code>
                </div>
                <p class="text-slate-600 text-sm">Digunakan untuk menghapus data artikel berita yang dipunyai kreator secara permanen dari basis data utama berdasarkan ID. Wajib membawa header otorisasi API Key.</p>
                
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest pt-2">JSON Response Sukses (200 OK):</p>
                <pre class="bg-slate-900 text-emerald-400 p-5 rounded-2xl text-xs overflow-x-auto shadow-inner">
{
    "status": "success",
    "message": "Artikel berita berhasil dihapus secara permanen dari sistem."
}</pre>
            </section>

        </main>
    </div>

    <footer class="bg-white border-t py-6 text-center text-xs text-slate-400 font-bold uppercase tracking-wider mt-20">
        © 2026 NewsDigital Tech - Project Tugas Akhir Pemrograman API
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>