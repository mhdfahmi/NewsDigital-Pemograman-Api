const express = require('express');
const cors = require('cors');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Mengaktifkan CORS agar API bisa diakses oleh frontend
app.use(cors());
app.use(express.json());

// Menyajikan folder 'public' sebagai file statis
app.use(express.static(path.join(__dirname, 'public')));

// Route utama untuk menampilkan index.html
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// Endpoint API Data (Data nyata untuk di-fetch ke frontend)
app.get('/api/news', (req, res) => {
    res.json({
        status: "success",
        data: [
            { 
                id: 1, 
                title: "Pertemuan Pertama Pemrograman API", 
                content: "Hari ini kelompok Fahmi berhasil mendeploy API menggunakan Node.js.",
                author: "fahmi sanjaya" 
            },
            { 
                id: 2, 
                title: "Berita Kemajuan Tugas Project Digital", 
                content: "Integrasi sistem frontend dan backend berjalan lancar.",
                author: "Arganta" 
            }
        ]
    });
});

// Menjalankan server
app.listen(PORT, () => {
    console.log(`Server berhasil berjalan di port ${PORT}`);
});

module.exports = app;