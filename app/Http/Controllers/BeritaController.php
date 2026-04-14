<?php

namespace App\Http\Controllers;

use App\Models\News; // Sesuai nama model Anda: News.php
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // Untuk tampilan Home Website
    public function index() {
        $berita = News::all();
        return view('home', compact('berita'));
    }

    // Untuk API di Postman
    public function getBeritaApi() {
        $berita = News::all();
        return response()->json([
            'status' => 'success',
            'data' => $berita
        ], 200);
    }
}