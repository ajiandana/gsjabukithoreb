<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalIbadah extends Model
{
    protected $fillable = [
        'judul', 
        'gambar', 
        'bulan', 
        'tahun', 
        'keterangan'
    ];

    protected $casts = [
        'tahun' => 'integer'
    ];
}
