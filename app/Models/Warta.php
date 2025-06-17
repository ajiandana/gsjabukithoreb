<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warta extends Model
{
    protected $fillable = [
        'judul',
        'gambar', 
        'penulis',
        'bulan',
        'tahun',
        'isi',
    ];
}
