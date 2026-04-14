<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->title }} - NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <nav class="border-b px-10 py-6 flex justify-between items-center sticky top-0 bg-white/80 backdrop-blur-md z-50">
        <a href="/" class="flex items-center gap-2 font-black text-xl text-indigo-600">
            <i data-lucide="arrow-left"></i> KEMBALI
        </a>
        <span class="font-bold text-slate-400 uppercase tracking-widest text-xs">Detail Artikel</span>
    </nav>

    <article class="max-w-4xl mx-auto py-20 px-6">
        <span class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block">
            {{ $item->kategori ?? 'TEKNOLOGI' }}
        </span>
        
        <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-8 leading-[1.1] tracking-tighter uppercase italic">
            {{ $item->title }}
        </h1>
        
        <div class="flex items-center gap-6 mb-12 py-8 border-y border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xl">
                {{ substr($item->user->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penulis</p>
                <p class="font-bold text-slate-800 text-lg">{{ $item->user->name ?? 'Anonim' }}</p>
            </div>
            <div class="ml-auto text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</p>
                <p class="font-bold text-slate-800">{{ $item->created_at->format('d F Y') }}</p>
            </div>
        </div>

        <div class="relative group">
            <img src="{{ asset('berita/' . $item->image) }}" 
                 alt="{{ $item->title }}"
                 class="w-full h-[500px] object-cover rounded-[3rem] mb-12 shadow-2xl transition duration-500 group-hover:scale-[1.01]"
                 onerror="this.src='https://placehold.co/1200x800?text=Gambar+Berita+Tidak+Ditemukan'">
        </div>

        <div class="prose prose-indigo prose-xl max-w-none text-slate-700 leading-[1.8] text-xl">
            {!! nl2br(e($item->content)) !!}
        </div>
    </article>

    <footer class="bg-slate-50 py-20 mt-20 text-center border-t border-slate-100">
        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">&copy; 2026 NewsDigital Portal</p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>