<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanDoa extends Model
{
    protected $fillable = [
        'user_id',
        'nama', 
        'kategori_id', 
        'isi_permohonan', 
        'perlu_konseling', 
        'no_hp',
        'status'
    ];

    protected $casts = [
        'perlu_konseling' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(KategoriDoa::class, 'kategori_id');
    }
}
