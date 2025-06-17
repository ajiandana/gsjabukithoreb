<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Baptis extends Model
{
    use HasFactory;

    protected $table = 'baptis';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nama_ayah',
        'nama_ibu',
        'tempat_lahir',
        'tgl_lahir',
        'no_hp',
        'status'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}