<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPastoral extends Model
{
    protected $table = 'status_pastoral';
    protected $fillable = ['nama', 'keterangan'];
}
