<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Departemen extends Model
{
    protected $fillable = ['nama', 'pastoral_id', 'informasi'];

    public function pastoral()
    {
        return $this->belongsTo(Pastoral::class);
    }

    public function pengurus()
    {
        return $this->hasMany(PengurusDepartemen::class);
    }

    public function ketua(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pengurus()->where('jabatan', 'ketua')->first()?->jemaat
        );
    }

    public function wakil(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pengurus()->where('jabatan', 'wakil')->first()?->jemaat
        );
    }

    public function sekretaris(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pengurus()->where('jabatan', 'sekretaris')->first()?->jemaat
        );
    }

    public function bendahara(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pengurus()->where('jabatan', 'bendahara')->first()?->jemaat
        );
    }
}
