<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pastoral extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'link_lokasi',
        'status_pastoral_id',
        'bio',
        'foto'
    ];

    protected $casts = [
        'tgl_lahir' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusPastoral::class, 'status_pastoral_id');
    }
}
