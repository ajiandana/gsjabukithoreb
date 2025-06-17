<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenyerahanAnak extends Model
{
    use HasFactory;

    protected $table = 'penyerahan_anak';
    
    protected $fillable = [
        'user_id',
        'nama_anak',
        'nama_ayah',
        'nama_ibu',
        'no_hp',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
