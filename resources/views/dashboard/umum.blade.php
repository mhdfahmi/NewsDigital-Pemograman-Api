<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Dashboard - Portal Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-indigo-900 via-slate-900 to-black">
        
        <div class="w-full max-w-4xl">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-black mb-4 bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent italic uppercase tracking-tighter">API Developer Portal</h1>
                <p class="text-slate-400 text-lg">Gunakan endpoint kami untuk integrasi berita real-time.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-slate-800/50 backdrop-blur-xl p-8 rounded-3xl border border-slate-700 shadow-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-indigo-500/20 text-indigo-400 rounded-2xl"><i data-lucide="key"></i></div>
                        <h2 class="text-xl font-bold">API Access Key</h2>
                    </div>
                    <p class="text-slate-400 text-sm mb-4 italic">Simpan key ini dengan aman. Jangan bagikan kepada siapapun.</p>
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-center select-all font-mono text-xl tracking-widest text-indigo-400 border-dashed">
                        {{ auth()->user()->api_key ?? 'KEY-TIDAK-DITEMUKAN' }}
                    </div>
                    <form action="/logout" method="POST" class="mt-8">@csrf <button class="w-full py-3 bg-slate-700 hover:bg-red-600 transition rounded-xl font-bold uppercase text-xs tracking-widest">Logout Session</button></form>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-xl p-8 rounded-3xl border border-slate-700 shadow-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-cyan-500/20 text-cyan-400 rounded-2xl"><i data-lucide="terminal"></i></div>
                        <h2 class="text-xl font-bold">Quick Guide</h2>
                    </div>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex items-center gap-2"><span class="w-16 font-bold text-indigo-400 uppercase">GET</span> <code>/api/berita</code></div>
                        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
                            <p class="text-xs font-bold text-slate-500 mb-1">Header Required:</p>
                            <p class="font-mono text-cyan-400 underline decoration-indigo-500">X-API-KEY: {{ auth()->user()->api_key }}</p>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed italic">*Note: Gunakan Thunder Client untuk testing response JSON di local environment Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>