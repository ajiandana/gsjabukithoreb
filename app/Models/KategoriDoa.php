<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDoa extends Model
{
    protected $fillable = ['nama'];

    public function permohonans()
    {
        return $this->hasMany(PermohonanDoa::class);
    }
}
