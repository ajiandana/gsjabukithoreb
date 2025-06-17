<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Jemaat extends Model
{
    protected $fillable = [
        'kode_jemaat',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'daerah_id',
        'no_hp',
        'link_lokasi'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    protected $appends = ['usia'];

    public function daerah()
    {
        return $this->belongsTo(Daerah::class);
    }

    protected function usia(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->tgl_lahir)->age
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->usia = Carbon::parse($model->tgl_lahir)->age;
        });
    }
}
