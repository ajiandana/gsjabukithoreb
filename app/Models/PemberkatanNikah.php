<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemberkatanNikah extends Model
{
    use HasFactory;

    protected $table = 'pemberkatan_nikah';
    
    protected $fillable = [
        'user_id',
        // Data Pria
        'pria_nama',
        'pria_sudah_baptis',
        'pria_ayah',
        'pria_ibu',
        
        // Data Wanita
        'wanita_nama',
        'wanita_sudah_baptis',
        'wanita_ayah',
        'wanita_ibu',
        
        // Data Pernikahan
        'rencana_tahun',
        'no_hp',
        'status'
    ];

    protected $casts = [
        'pria_sudah_baptis' => 'boolean',
        'wanita_sudah_baptis' => 'boolean',
        'rencana_tahun' => 'integer',
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
