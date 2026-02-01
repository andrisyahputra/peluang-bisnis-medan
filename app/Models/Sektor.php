<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sektor extends Model
{
    use HasFactory;

    protected $table = 'sektors';

    protected $fillable = [
        'nama_sektor',
        'warna',
        'ikon',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function peluangBisnis(): HasMany
    {
        return $this->hasMany(PeluangBisnis::class, 'sektor_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    public function getJumlahPeluangAttribute(): int
    {
        return $this->peluangBisnis()->where('is_active', true)->count();
    }

    public function getJumlahUnggulanAttribute(): int
    {
        return $this->peluangBisnis()
            ->where('is_active', true)
            ->where('status_unggulan', true)
            ->count();
    }
}