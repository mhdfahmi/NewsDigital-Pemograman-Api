<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="bg-white border-b px-10 py-4 flex justify-between items-center sticky top-0 z-50">
        <a href="/dashboard" class="flex items-center gap-2 font-black text-xl text-indigo-600">
            <i data-lucide="arrow-left"></i> BATAL
        </a>
        <span class="text-xs font-black text-amber-500 bg-amber-50 px-3 py-1.5 rounded-full uppercase tracking-wider">Mode Koreksi Berita</span>
    </nav>

    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
            <h1 class="text-2xl font-black italic uppercase tracking-tighter mb-8">Edit <span class="text-indigo-600">Berita Anda</span></h1>

            <form action="{{ route('berita.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul', $news->title) }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Cover Image Saat Ini</label>
                        <div class="w-full h-40 bg-slate-100 rounded-2xl overflow-hidden flex items-center justify-center border border-dashed">
                            @if($news->image)
                                <img src="{{ asset('berita/' . $news->image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs text-slate-400 italic">Tidak ada gambar</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Ganti Cover Image</label>
                        <input type="file" name="foto" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-medium text-slate-500">
                        <p class="text-[10px] text-slate-400 mt-2">*Biarkan kosong jika tidak ingin mengganti gambar cover lama.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Isi Berita Lengkap</label>
                    <textarea name="isi_berita" rows="8" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-medium text-slate-700 leading-relaxed">{{ old('isi_berita', $news->content) }}</textarea>
                </div>

                <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5"></i>
                    <p class="text-xs text-amber-700 font-medium leading-relaxed">
                        <strong>Catatan Moderasi:</strong> Setelah Anda menekan tombol simpan, status berita ini otomatis berubah kembali menjadi <span class="underline font-bold">Pending</span> dan ditarik dari halaman utama sampai disetujui ulang oleh Admin.
                    </p>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 shadow-xl transition-all active:scale-95 shadow-indigo-100">
                    SIMPAN PERUBAHAN & AJUKAN ULANG
                </button>
            </form>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>