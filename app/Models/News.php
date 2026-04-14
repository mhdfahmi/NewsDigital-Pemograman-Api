<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // SINKRON: Nama tabel sesuai database Anda di HeidiSQL
    protected $table = 'news';

    // SINKRON: Kolom yang diizinkan sesuai gambar database Anda
    protected $fillable = [
        'title', 
        'content', 
        'image', 
        'status', 
        'user_id'
    ];

    /**
     * Relasi ke model User
     * Menghubungkan user_id di tabel news ke id di tabel users
     */
    public function user()
    {
        // Parameter kedua 'user_id' memastikan Laravel mencari kolom yang benar di DB Anda
        return $this->belongsTo(User::class, 'user_id');
    }
}