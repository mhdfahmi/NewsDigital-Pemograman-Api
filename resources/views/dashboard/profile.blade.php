<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - WinniCode News</title>
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
            <i data-lucide="arrow-left"></i> KEMBALI
        </a>
        <div class="flex items-center gap-4">
             <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black uppercase tracking-widest">{{ auth()->user()->admin }}</span>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-16 px-6">
        <div class="text-center mb-12">
            <div class="w-24 h-24 bg-indigo-600 rounded-[2rem] mx-auto mb-6 flex items-center justify-center text-white text-4xl font-black shadow-xl shadow-indigo-100">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h1 class="text-3xl font-black italic uppercase tracking-tighter">Pengaturan <span class="text-indigo-600">Profil</span></h1>
            <p class="text-slate-400 mt-2 text-sm">Kelola informasi akun Anda di sini.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-2xl mb-8 font-bold text-center animate-bounce">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Alamat Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700">
                </div>

                <hr class="border-slate-50">

                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-1 tracking-widest italic">Password Baru</label>
                    <p class="text-[10px] text-slate-400 mb-3">*Kosongkan jika tidak ingin mengubah password</p>
                    <input type="password" name="password" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700" placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest italic">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 shadow-xl transition-all active:scale-95 shadow-indigo-100">
                    SIMPAN PERUBAHAN
                </button>
            </form>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>