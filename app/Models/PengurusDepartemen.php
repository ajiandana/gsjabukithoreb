<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusDepartemen extends Model
{
    protected $fillable = ['departemen_id', 'jemaat_id', 'jabatan'];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class);
    }
}
