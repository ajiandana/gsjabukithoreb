<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $fillable = ['kegiatan_id', 'gambar', 'caption'];
    
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
