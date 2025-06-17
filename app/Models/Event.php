<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'gambar',
        'judul',
        'tanggal',
        'tempat',
        'jam_mulai',
        'jam_selesai',
        'status',
        'informasi',
        'tanggal_selesai',
        'is_multi_day'
    ];

    protected $casts = [
        'is_multi_day' => 'boolean',
        'tanggal' => 'date',
        'tanggal_selesai' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i'
    ];

    // Scope untuk filter status
    public function scopeSegera($query)
    {
        return $query->where(function($q) {
            $q->where('tanggal', '>', today()) // Event yang belum mulai
              ->orWhere(function($q) {
                  $q->where('is_multi_day', true)
                    ->where('tanggal_selesai', '>', today()); // Multi-day yang belum selesai
              });
        })->orderBy('tanggal');
    }

    public function scopeBerlangsung($query)
    {
        return $query->where(function($q) {
            $q->where(function($q) {
                // Single day event hari ini
                $q->where('is_multi_day', false)
                  ->whereDate('tanggal', today());
            })->orWhere(function($q) {
                // Multi-day event yang mencakup hari ini
                $q->where('is_multi_day', true)
                  ->whereDate('tanggal', '<=', today())
                  ->whereDate('tanggal_selesai', '>=', today());
            });
        })->orderBy('jam_mulai');
    }

    public function scopeSelesai($query)
    {
        return $query->where(function($q) {
            $q->where(function($q) {
                // Single day event yang sudah lewat
                $q->where('is_multi_day', false)
                  ->whereDate('tanggal', '<', today());
            })->orWhere(function($q) {
                // Multi-day event yang sudah lewat tanggal selesai
                $q->where('is_multi_day', true)
                  ->whereDate('tanggal_selesai', '<', today());
            });
        })->orderByDesc('tanggal');
    }

    public function setIsMultiDayAttribute($value)
    {
        $this->attributes['is_multi_day'] = (bool)$value;
    }

    public function getTanggalSelesaiAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function determineStatus($tanggal, $tanggalSelesai = null, $isMultiDay = false)
    {
        $today = today();
        $start = Carbon::parse($tanggal);
        $end = $isMultiDay ? Carbon::parse($tanggalSelesai) : $start;

        if ($today->gt($end)) {
            return 'selesai';
        } elseif ($today->between($start, $end)) {
            return 'berlangsung';
        }
        return 'segera';
    }
}