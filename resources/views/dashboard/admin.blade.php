<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NewsDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-900">
    
    <nav class="bg-white/80 backdrop-blur-md border-b sticky top-0 z-40 px-6 md:px-10 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 font-black text-2xl text-indigo-600">
            <i data-lucide="shield-check"></i> ADMIN PANEL
        </div>
        <div class="flex items-center gap-4 md:gap-6">
            <span class="hidden md:block text-gray-400 text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
            
            <div class="flex items-center gap-2 text-slate-600">
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center border border-indigo-100 text-white">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div class="hidden md:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Administrator</p>
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-50 text-red-500 p-2.5 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="md:col-span-1">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight text-center md:text-left">Control <span class="text-indigo-600">Center</span></h1>
                <p class="text-slate-500 font-medium mt-1 text-center md:text-left">Validasi dan kelola semua konten portal.</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="newspaper"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Berita</p>
                    <p class="text-2xl font-black text-slate-800">{{ $totalNews }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="users"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total User</p>
                    <p class="text-2xl font-black text-slate-800">{{ $totalUser }}</p>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl flex items-center gap-3 font-bold text-sm shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-black text-slate-800 uppercase tracking-widest text-xs flex items-center gap-2">
                    <i data-lucide="list" class="w-4 h-4 text-indigo-600"></i> Antrean Moderasi & Database Berita
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            <th class="px-8 py-6">Berita</th>
                            <th class="px-8 py-6">Penulis</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-center">Aksi Moderasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($news as $item)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm shrink-0">
                                        <img src="{{ $item->image ? asset('berita/' . $item->image) : asset('images/default.jpg') }}" 
     class="w-20 h-20 object-cover" 
     onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-slate-900 leading-tight">{{ $item->judul }}</div>
                                        <div class="text-[10px] text-indigo-500 font-black mt-1 uppercase tracking-tighter">{{ $item->kategori }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-700 text-sm">{{ $item->penulis }}</span>
                                <p class="text-[10px] text-slate-400 font-medium">{{ $item->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($item->status == 'published')
                                    <span class="bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">Published</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100 italic">Waiting ACC</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    @if($item->status == 'pending')
                                    <form action="{{ route('berita.approve', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                                            <i data-lucide="check" class="w-3 h-3"></i> Approve
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini dari sistem?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i data-lucide="database-zap" class="w-16 h-16 mb-4"></i>
                                    <p class="font-black text-xs uppercase tracking-widest">Database Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>