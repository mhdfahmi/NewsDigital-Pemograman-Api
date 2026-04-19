<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creator Dashboard - NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom scrollbar untuk modal agar terlihat lebih bersih */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 text-slate-900">
    
    <nav class="bg-white/80 backdrop-blur-md border-b sticky top-0 z-40 px-6 md:px-10 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 font-black text-2xl text-indigo-600">
            <i data-lucide="pen-tool"></i> NewsDigital
        </div>
        <div class="flex items-center gap-4 md:gap-6">
            <span class="hidden md:block text-gray-400 text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
            
            <a href="{{ route('profile') }}" class="flex items-center gap-2 text-slate-600 hover:text-indigo-600 transition-all">
                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div class="hidden md:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Creator</p>
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                </div>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-50 text-red-500 p-2.5 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard <span class="text-indigo-600">Creator</span></h1>
                <p class="text-slate-500 font-medium mt-1">Kelola dan publikasikan karya tulis Anda.</p>
            </div>
            
            <button onclick="toggleModal()" class="group bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.15em] hover:bg-slate-900 transition-all shadow-xl shadow-indigo-100 flex items-center gap-3">
                <i data-lucide="plus-circle" class="w-5 h-5 group-hover:rotate-90 transition-transform duration-500"></i>
                BUAT ARTIKEL BARU
            </button>
        </div>

        @if(session('success'))
        <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl flex items-center gap-3 font-bold text-sm shadow-sm animate-bounce">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 gap-4">
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h2 class="font-black text-slate-800 uppercase tracking-widest text-xs">Riwayat Publikasi Anda ({{ $countMyNews }})</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-8 py-6">Informasi Berita</th>
                                <th class="px-8 py-6 text-center">Status</th>
                                <th class="px-8 py-6">Kategori</th>
                                <th class="px-8 py-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($myNews as $item)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-100 shadow-sm shrink-0">
                                            <img src="{{ $item->image ? asset('berita/' . $item->image) : asset('images/default.jpg') }}" 
                                                 class="w-full h-full object-cover" 
                                                 onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $item->judul }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold mt-1 uppercase">{{ $item->created_at->translatedFormat('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($item->status == 'published')
                                        <span class="bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">Live</span>
                                    @else
                                        <span class="bg-amber-50 text-amber-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest italic">Pending</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-bold text-slate-500 italic">#{{ $item->kategori }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <form action="{{ route('berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i data-lucide="folder-open" class="w-16 h-16 mb-4"></i>
                                        <p class="font-black text-xs uppercase tracking-widest">Belum ada karya tulis</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="modalArtikel" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>
        
        <div class="absolute inset-0 flex items-start justify-center p-4 overflow-y-auto custom-scroll">
            <div id="modalContent" class="bg-white w-full max-w-2xl rounded-[40px] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 my-8">
                
                <div class="p-8 border-b border-slate-50 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h2 class="text-2xl font-black text-slate-900 italic uppercase tracking-tighter">Tulis <span class="text-indigo-600">Berita</span></h2>
                    <button onclick="toggleModal()" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Judul Berita</label>
                        <input type="text" name="judul" required value="{{ old('judul') }}"
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-800 placeholder:text-slate-300 transition-all" 
                               placeholder="Masukkan judul yang menarik...">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Kategori</label>
                            <select name="kategori" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-800 appearance-none cursor-pointer">
                                <option value="Teknologi">Teknologi</option>
                                <option value="Hiburan">Hiburan</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Bisnis">Bisnis</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Cover Image</label>
                            <input type="file" name="foto" required
                                   class="w-full text-xs text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Isi Berita</label>
                        <textarea name="isi_berita" rows="5" required 
                                  class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-medium text-slate-700 transition-all placeholder:text-slate-300" 
                                  placeholder="Tuliskan isi berita lengkap Anda di sini...">{{ old('isi_berita') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-900 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                        KIRIM KE ADMIN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleModal() {
            const modal = document.getElementById('modalArtikel');
            const content = document.getElementById('modalContent');
            
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                // Tambahkan sedikit delay agar animasi Tailwind berjalan
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 20);
                // Mencegah body agar tidak ikut scroll saat modal terbuka
                document.body.style.overflow = 'hidden';
            } else {
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }
    </script>
</body>
</html>