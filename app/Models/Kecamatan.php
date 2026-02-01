<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';

    protected $fillable = [
        'nama_kecamatan',
        'kode_kecamatan',
        'geojson_data',
        'latitude',
        'longitude',
        'luas_wilayah',
        'jumlah_penduduk',
        'deskripsi',
        'warna',
        'is_active',
    ];

    protected $casts = [
        'geojson_data' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    public function peluangBisnis(): HasMany
    {
        return $this->hasMany(PeluangBisnis::class, 'kecamatan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getJumlahPeluangAttribute(): int
    {
        return $this->peluangBisnis()->where('is_active', true)->count();
    }

    public function getPeluangPerSektorAttribute(): array
    {
        return $this->peluangBisnis()
            ->where('is_active', true)
            ->selectRaw('sektor_id, COUNT(*) as total')
            ->groupBy('sektor_id')
            ->pluck('total', 'sektor_id')
            ->toArray();
    }
}