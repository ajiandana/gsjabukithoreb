<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = ['judul', 'deskripsi', 'tanggal'];
    // Di app/Models/Kegiatan.php
    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value);
    }
    
    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }
}
