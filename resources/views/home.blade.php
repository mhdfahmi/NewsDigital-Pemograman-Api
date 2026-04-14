<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-lg text-white">
                    <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                </div>
                <span class="font-black text-xl tracking-tighter italic">NEWS<span class="text-indigo-600">Digital</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-slate-600 font-bold text-sm hover:text-indigo-600 transition-colors">
                        DASHBOARD
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-red-600 transition-all shadow-lg shadow-slate-200">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-full text-sm font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-xl shadow-indigo-100">
                        LOGIN
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">
                Berita <span class="text-indigo-600">Terbaru</span> Hari Ini
            </h1>
            <p class="text-slate-500 font-medium max-w-2xl">Dapatkan informasi teknologi dan update terbaru dari komunitas creator NewsDigital.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($news as $item)
            <article class="group bg-white rounded-[32px] overflow-hidden border border-slate-100 hover:border-indigo-100 hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 cursor-pointer"
                     onclick="openDetail('{{ $item->id }}', '{{ addslashes($item->title) }}', '{{ $item->kategori ?? 'Teknologi' }}', '{{ $item->user->name ?? 'Anonim' }}', '{{ $item->created_at->diffForHumans() }}', '{{ $item->image }}', '{{ addslashes($item->content) }}')">
                
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('berita/' . $item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                         onerror="this.src='https://placehold.co/600x400?text=Gambar+Tidak+Tersedia'">
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-indigo-600 shadow-sm border border-slate-100">
                            {{ $item->kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-indigo-600">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-tight">{{ $item->user->name ?? 'Anonim' }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-medium text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h3 class="text-xl font-extrabold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors leading-snug">
                        {{ $item->title }}
                    </h3>
                    
                    <p class="text-slate-500 leading-relaxed text-sm line-clamp-3 mb-6">
                        {{ $item->content }}
                    </p>

                    <div class="flex items-center text-indigo-600 font-black text-[10px] uppercase tracking-widest group-hover:gap-3 transition-all">
                        BACA SELENGKAPNYA <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-white p-10 rounded-[40px] border-2 border-dashed border-slate-200 inline-block">
                    <i data-lucide="newspaper" class="w-16 h-16 text-slate-200 mx-auto mb-4"></i>
                    <p class="text-slate-400 font-bold">Belum ada berita yang diterbitkan.</p>
                </div>
            </div>
            @endforelse
        </div>
    </main>

    <div id="modalDetail" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-[40px] overflow-hidden shadow-2xl relative flex flex-col">
                <button onclick="closeDetail()" class="absolute top-6 right-6 z-10 bg-white/20 hover:bg-white/40 backdrop-blur-xl text-white p-3 rounded-full transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>

                <div class="overflow-y-auto">
                    <div class="h-96 relative">
                        <img id="detailFoto" src="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-10 left-10 right-10">
                            <span id="detailKategori" class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-4 inline-block shadow-xl shadow-indigo-500/20"></span>
                            <h2 id="detailJudul" class="text-3xl md:text-5xl font-black text-white leading-tight"></h2>
                        </div>
                    </div>

                    <div class="p-10">
                        <div class="flex flex-wrap items-center gap-6 mb-10 pb-10 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penulis</p>
                                    <p id="detailPenulis" class="font-bold text-slate-800"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                    <i data-lucide="calendar" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diterbitkan</p>
                                    <p id="detailTanggal" class="font-bold text-slate-800"></p>
                                </div>
                            </div>
                        </div>
                        <div id="detailIsi" class="text-slate-600 leading-[1.8] text-lg font-medium space-y-4 whitespace-pre-line"></div>
                        <div class="mt-12 pt-10 border-t border-slate-100 flex justify-center">
                            <a id="btnPerluas" href="#" class="bg-slate-900 text-white px-10 py-5 rounded-3xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                                Buka Halaman Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function openDetail(id, judul, kategori, penulis, tanggal, foto, isi) {
            document.getElementById('detailJudul').innerText = judul;
            document.getElementById('detailKategori').innerText = kategori;
            document.getElementById('detailPenulis').innerText = penulis;
            document.getElementById('detailTanggal').innerText = tanggal;
            document.getElementById('detailFoto').src = "{{ asset('berita') }}/" + foto;
            document.getElementById('detailIsi').innerText = isi;
            document.getElementById('btnPerluas').href = "/berita/" + id;
            document.getElementById('modalDetail').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDetail() {
            document.getElementById('modalDetail').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>