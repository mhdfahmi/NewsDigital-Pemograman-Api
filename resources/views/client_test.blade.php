<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsDigital - API Client Tester</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Fira+Code:wght@400;500&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .code-font { font-family: 'Fira Code', monospace; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-xl text-white shadow-md shadow-indigo-600/20">
                    <i data-lucide="flask-conical" class="w-5 h-5"></i>
                </div>
                <span class="font-black text-xl tracking-tighter italic text-slate-900">NEWS<span class="text-indigo-600">Digital</span></span>
                <span class="ml-2 bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border border-indigo-100">REST Client</span>
            </div>
            <div>
                <a href="{{ route('home') }}" class="group flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-indigo-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all border border-slate-200 shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-10 flex flex-col gap-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <section class="lg:col-span-7 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-6">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                    <i data-lucide="terminal" class="w-5 h-5 text-indigo-600"></i>
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">API Request Workbench</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Method</label>
                        <div class="relative">
                            <select id="api-method" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-emerald-600 focus:outline-none focus:border-indigo-500 appearance-none cursor-pointer transition-colors">
                                <option value="GET" class="text-emerald-600 font-bold bg-white">GET</option>
                                <option value="POST" class="text-amber-600 font-bold bg-white">POST</option>
                                <option value="DELETE" class="text-rose-600 font-bold bg-white">DELETE</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Endpoint URL</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-bold text-slate-400 code-font select-none">/api</span>
                            <input type="text" id="api-url" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-14 pr-4 py-3 text-slate-800 font-semibold code-font focus:outline-none focus:border-indigo-500 transition-colors" value="/berita">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Headers / Kunci Keamanan</label>
                    <div class="flex rounded-xl overflow-hidden border border-slate-200 focus-within:border-indigo-500 transition-colors shadow-sm">
                        <span class="bg-slate-100 px-4 py-3 text-xs font-bold text-slate-600 code-font border-r border-slate-200 flex items-center">x-api-key</span>
                        <input type="text" id="api-key" class="w-full bg-slate-50 px-4 py-3 text-sm text-indigo-700 placeholder-slate-400 focus:outline-none font-medium" placeholder="Tempel token x-api-key di sini...">
                    </div>
                </div>

                <div id="post-body-section" class="hidden bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                    <div class="flex items-center gap-2 text-amber-600 font-bold text-xs uppercase tracking-wider">
                        <i data-lucide="file-edit" class="w-4 h-4"></i> Form Payload Data Baru
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Judul Artikel</label>
                            <input type="text" id="body-title" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-amber-500" placeholder="Contoh: Terobosan AI Terbaru">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Kategori</label>
                            <input type="text" id="body-kategori" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-amber-500" placeholder="Contoh: Teknologi">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-1">Isi Konten Berita</label>
                        <textarea id="body-content" rows="4" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-amber-500 resize-none" placeholder="Tulis rincian isi artikel..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">User ID</label>
                            <input type="number" id="body-user-id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-amber-500" placeholder="ID">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Sampul Gambar</label>
                            <input type="file" id="body-image" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-500 focus:outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div id="delete-body-section" class="hidden bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center gap-2 text-rose-600 font-bold text-xs uppercase tracking-wider mb-3">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Parameter Penghapusan Data
                    </div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-1">ID Berita yang Ingin Dihapus</label>
                    <input type="number" id="delete-id" class="w-full sm:w-1/3 bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 font-bold code-font" placeholder="Contoh: 12">
                </div>

                <div class="mt-auto pt-4">
                    <button id="btn-send" class="w-full bg-indigo-600 hover:bg-indigo-500 active:scale-[0.99] text-white font-bold py-4 rounded-xl shadow-md shadow-indigo-600/10 transition-all flex items-center justify-center gap-2 text-sm tracking-wider uppercase">
                        <i data-lucide="zap" class="w-4 h-4 fill-current"></i> Kirim Permintaan (Send Request)
                    </button>
                </div>
            </section>

            <section class="lg:col-span-5 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col min-h-[450px]">
                <div class="flex justify-between items-center pb-4 border-b border-slate-100 mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="activity" class="w-5 h-5 text-emerald-600"></i>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Response Console</h3>
                    </div>
                    <span id="response-status" class="px-2.5 py-1 text-xs font-extrabold rounded-md bg-slate-100 text-slate-600 border border-slate-200 code-font">STATUS: --</span>
                </div>
                <div class="flex-1 flex flex-col bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden p-4 shadow-inner">
                    <pre id="json-output" class="flex-1 text-xs text-slate-600 font-medium code-font whitespace-pre-wrap break-all overflow-y-auto max-h-[500px] leading-relaxed">// Respon JSON dari REST API server akan tercetak di sini...</pre>
                </div>
            </section>
        </div>

        <section class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-6">
                <i data-lucide="folder-heart" class="w-5 h-5 text-indigo-600"></i>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">API Testing Collections Repository</h2>
                    <p class="text-xs text-slate-500">Kumpulan blueprint URL, Headers, dan JSON asli untuk memudahkan pengujian.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="lock" class="w-4 h-4 text-indigo-600"></i>
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Modul Autentikasi (Auth)</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-amber-100 text-amber-700 text-[10px] font-extrabold px-2 py-0.5 rounded border border-amber-200 code-font">POST</span>
                                        <h4 class="text-slate-800 text-sm font-bold">User Login</h4>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-xl border border-slate-200 mb-3 shadow-sm">
                                    <code class="text-xs text-slate-700 code-font break-all truncate mr-2" id="url-login">http://localhost:8000/api/auth/login</code>
                                    <button onclick="copyToClipboard('url-login')" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors" title="Salin URL"><i data-lucide="copy" class="w-3.5 h-3.5"></i></button>
                                </div>
                                <div class="mb-3">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Headers:</span>
                                    <div class="bg-white p-2 rounded-lg text-[11px] code-font text-indigo-600 border border-slate-200 shadow-sm">
                                        Accept: application/json
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">JSON Body Content:</span>
                                    <pre class="bg-white text-slate-700 p-3 rounded-xl text-[11px] code-font overflow-x-auto border border-slate-200 shadow-sm">{
    <span class="text-indigo-600">"email"</span>: "fahmiganteng@gmail.com",
    <span class="text-indigo-600">"password"</span>: "password123"
}</pre>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-amber-100 text-amber-700 text-[10px] font-extrabold px-2 py-0.5 rounded border border-amber-200 code-font">POST</span>
                                        <h4 class="text-slate-800 text-sm font-bold">User Logout</h4>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-xl border border-slate-200 mb-3 shadow-sm">
                                    <code class="text-xs text-slate-700 code-font break-all truncate mr-2" id="url-logout">http://localhost:8000/api/auth/logout</code>
                                    <button onclick="copyToClipboard('url-logout')" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors" title="Salin URL"><i data-lucide="copy" class="w-3.5 h-3.5"></i></button>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Headers:</span>
                                    <div class="bg-white p-2 rounded-lg text-[11px] code-font text-slate-600 border border-slate-200 shadow-sm space-y-1">
                                        <div>Accept: application/json</div>
                                        <div class="text-indigo-600 font-bold">x-api-key: [Token_Hasil_Login]</div>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-4 leading-relaxed bg-white p-2.5 rounded-xl border border-slate-200 shadow-sm">
                                    💡 <span class="text-slate-700 font-semibold">Keterangan:</span> Mengirimkan request ke endpoint logout server guna membersihkan token session yang terdaftar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-3 pt-4 border-t border-slate-100">
                        <i data-lucide="newspaper" class="w-4 h-4 text-emerald-600"></i>
                        <h3 class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Modul Berita (News API)</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                            <div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-2 py-0.5 rounded border border-emerald-200 code-font inline-block mb-2">GET</span>
                                <h4 class="text-slate-800 text-sm font-bold mb-2">Get All Berita</h4>
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-xl border border-slate-200 mb-3 shadow-sm">
                                    <code class="text-xs text-slate-700 code-font truncate mr-2" id="url-get-all">http://localhost:8000/api/berita</code>
                                    <button onclick="copyToClipboard('url-get-all')" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors"><i data-lucide="copy" class="w-3.5 h-3.5"></i></button>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Headers:</span>
                                <div class="bg-white p-2 rounded-lg text-[11px] code-font text-indigo-600 border border-slate-200 shadow-sm">Accept: application/json</div>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                            <div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-2 py-0.5 rounded border border-emerald-200 code-font inline-block mb-2">GET</span>
                                <h4 class="text-slate-800 text-sm font-bold mb-2">Get Detail Berita</h4>
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-xl border border-slate-200 mb-3 shadow-sm">
                                    <code class="text-xs text-slate-700 code-font truncate mr-2" id="url-get-detail">http://localhost:8000/api/berita/{id}</code>
                                    <button onclick="copyToClipboard('url-get-detail')" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors"><i data-lucide="copy" class="w-3.5 h-3.5"></i></button>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Headers:</span>
                                <div class="bg-white p-2 rounded-lg text-[11px] code-font text-indigo-600 border border-slate-200 shadow-sm">Accept: application/json</div>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                            <div>
                                <span class="bg-rose-100 text-rose-700 text-[10px] font-extrabold px-2 py-0.5 rounded border border-rose-200 code-font inline-block mb-2">DELETE</span>
                                <h4 class="text-slate-800 text-sm font-bold mb-2">Delete Berita</h4>
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-xl border border-slate-200 mb-3 shadow-sm">
                                    <code class="text-xs text-slate-700 code-font truncate mr-2" id="url-del">http://localhost:8000/api/berita/{id}</code>
                                    <button onclick="copyToClipboard('url-del')" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors"><i data-lucide="copy" class="w-3.5 h-3.5"></i></button>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Headers:</span>
                                <div class="bg-white p-2 rounded-lg text-[11px] code-font text-slate-600 border border-slate-200 shadow-sm space-y-0.5">
                                    <div>Accept: application/json</div>
                                    <div class="text-indigo-600 font-semibold">x-api-key: [Token_Auth]</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t border-slate-200 text-center py-4 text-xs text-slate-500 font-medium shadow-sm">
        NewsDigital Hub Engine &bull; Environment Live Tester
    </footer>

    <script>
        lucide.createIcons();

        function copyToClipboard(elementId) {
            const textToCopy = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                alert('✓ Berhasil menyalin URL: ' + textToCopy);
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        }

        const methodSelect = document.getElementById('api-method');
        const postSection = document.getElementById('post-body-section');
        const deleteSection = document.getElementById('delete-body-section');
        const apiUrlInput = document.getElementById('api-url');
        const btnSend = document.getElementById('btn-send');

        methodSelect.addEventListener('change', function() {
            const val = this.value;
            if(val === 'POST') {
                postSection.classList.remove('hidden');
                deleteSection.classList.add('hidden');
                apiUrlInput.value = '/berita';
                this.className = "w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-amber-600 focus:outline-none appearance-none cursor-pointer transition-colors";
            } else if(val === 'DELETE') {
                postSection.classList.add('hidden');
                deleteSection.classList.remove('hidden');
                apiUrlInput.value = '/berita/1';
                this.className = "w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-rose-600 focus:outline-none appearance-none cursor-pointer transition-colors";
            } else {
                postSection.classList.add('hidden');
                deleteSection.classList.add('hidden');
                apiUrlInput.value = '/berita';
                this.className = "w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-emerald-600 focus:outline-none appearance-none cursor-pointer transition-colors";
            }
        });

        btnSend.addEventListener('click', async function() {
            const method = methodSelect.value;
            const apiKey = document.getElementById('api-key').value;
            const statusBadge = document.getElementById('response-status');
            const jsonOutput = document.getElementById('json-output');
            const customPath = apiUrlInput.value.trim();
            
            if(!customPath) {
                alert('Endpoint URL tidak boleh kosong!');
                return;
            }

            let url = `/api${customPath.startsWith('/') ? '' : '/'}${customPath}`;

            jsonOutput.textContent = "Mengirimkan request ke REST server...";
            statusBadge.className = "px-2.5 py-1 text-xs font-extrabold rounded-md bg-amber-100 text-amber-700 border border-amber-200 code-font animate-pulse";
            statusBadge.textContent = "SENDING";

            let headers = { 'Accept': 'application/json' };
            if(apiKey) { headers['x-api-key'] = apiKey; }
            let options = { method: method, headers: headers };

            if(method === 'DELETE' && customPath === '/berita/1') {
                const deleteId = document.getElementById('delete-id').value;
                if(deleteId) { url = `/api/berita/${deleteId}`; }
            }

            if(method === 'POST') {
                const formData = new FormData();
                formData.append('title', document.getElementById('body-title').value);
                formData.append('kategori', document.getElementById('body-kategori').value);
                formData.append('content', document.getElementById('body-content').value);
                formData.append('user_id', document.getElementById('body-user-id').value);
                const fileInput = document.getElementById('body-image');
                if(fileInput.files[0]) { formData.append('image', fileInput.files[0]); }
                options.body = formData;
            }

            try {
                const response = await fetch(url, options);
                const status = response.status;
                const data = await response.json();
                
                if (status >= 200 && status < 300) {
                    statusBadge.className = "px-2.5 py-1 text-xs font-extrabold rounded-md bg-emerald-100 text-emerald-700 border border-emerald-200 code-font";
                    jsonOutput.className = "flex-1 text-xs text-slate-700 font-medium code-font whitespace-pre-wrap break-all overflow-y-auto";
                } else {
                    statusBadge.className = "px-2.5 py-1 text-xs font-extrabold rounded-md bg-rose-100 text-rose-700 border border-rose-200 code-font";
                    jsonOutput.className = "flex-1 text-xs text-rose-600 font-medium code-font whitespace-pre-wrap break-all overflow-y-auto";
                }
                statusBadge.textContent = `HTTP ${status}`;
                jsonOutput.textContent = JSON.stringify(data, null, 4);
            } catch (error) {
                statusBadge.className = "px-2.5 py-1 text-xs font-extrabold rounded-md bg-rose-100 text-rose-700 border border-rose-200 code-font";
                statusBadge.textContent = "FAIL";
                jsonOutput.className = "flex-1 text-xs text-rose-600 font-medium code-font";
                jsonOutput.textContent = `// Gangguan Jaringan / Server:\n${error.message}`;
            }
        });
    </script>
</body>
</html>