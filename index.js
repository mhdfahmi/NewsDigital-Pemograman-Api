const express = require('express');
const cors = require('cors');
const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors());
app.use(express.json());

// Endpoint Utama / Beranda
app.get('/', (req, res) => {
    res.json({
      status: "success",
      message: "API News Digital Berhasil Online menggunakan Node.js Express!"
    });
});

// Endpoint Jalur Data Berita Kelompokmu
app.get('/api/news', (req, res) => {
    res.json({
        status: "success",
        data: [
            { 
                id: 1, 
                title: "Pertemuan Pertama Pemrograman API", 
                content: "Hari ini kelompok Fahmi berhasil mendeploy API menggunakan Node.js.",
                author: "Muhammad Fahmi" 
            },
            { 
                id: 2, 
                title: "Berita Kemajuan Tugas Project Digital", 
                content: "Integrasi sistem frontend dan backend berjalan lancar.",
                author: "Adam & Heraldi" 
            }
        ]
    });
});

app.listen(PORT, () => {
    console.log(`Server berjalan di port ${PORT}`);
});

module.exports = app;