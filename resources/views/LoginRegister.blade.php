<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - News Portal API</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
    
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex p-4 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-200 mb-4 text-white">
                <i data-lucide="zap" class="w-8 h-8 fill-current"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">NEWS <span class="text-indigo-600">Digital</span></h1>
            <p class="text-slate-500 font-medium">Portal Berita & Developer Access</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-sm">
                <ul class="text-sm font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass p-8 rounded-3xl shadow-2xl border border-white" x-data="{ tab: 'login' }">
            <div class="flex p-1 bg-slate-200/50 rounded-xl mb-8">
                <button @click="tab = 'login'" :class="tab === 'login' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="flex-1 py-2 rounded-lg font-bold text-sm transition-all duration-300">MASUK</button>
                <button @click="tab = 'register'" :class="tab === 'register' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="flex-1 py-2 rounded-lg font-bold text-sm transition-all duration-300">DAFTAR</button>
            </div>

            <form x-show="tab === 'login'" action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="name@company.com">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="password" name="password" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Masuk ke Dashboard
                </button>
            </form>

            <form x-show="tab === 'register'" action="{{ url('/register') }}" method="POST" class="space-y-5" style="display: none;">
                @csrf
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="text" name="name" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Your Name">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="email" name="email" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="email@example.com">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="password" name="password" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Min. 8 characters">
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Daftar & Ambil API KEY
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-slate-400 text-sm font-medium">
            &copy; 2026 NewsDigital Tech. <br>
            <span class="text-xs uppercase tracking-widest">Portal Berita - Muhammad Fahmi Abdillah Mahri</span>
        </p>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>