<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'api_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string'
        ];
    }

    public function generateToken()
    {
        $plainToken = Str::random(60);
        $this->api_token = hash('sha256', $plainToken);
        $this->save();
        
        return $plainToken;
    }
    
    public function permohonanDoa()
    {
        return $this->hasMany(PermohonanDoa::class, 'user_id');
    }

    public function baptis()
    {
        return $this->hasMany(Baptis::class);
    }

    public function penyerahanAnak()
    {
        return $this->hasMany(PenyerahanAnak::class);
    }

    public function pemberkatanNikah()
    {
        return $this->hasMany(PemberkatanNikah::class);
    }

    public function getNamaAttribute()
    {
        return $this->attributes['name'];
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function pastoral()
    {
        return $this->hasOne(Pastoral::class, 'user_id');
    }

    public function jemaat()
    {
        return $this->hasOne(Jemaat::class, 'id');
    }
}