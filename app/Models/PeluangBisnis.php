<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeluangBisnis extends Model
{
    use HasFactory;

    protected $table = 'peluang_bisnis';

    protected $fillable = [
        'nama_usaha',
        'sektor_id',
        'kecamatan_id',
        'latitude',
        'longitude',
        'status_unggulan',
        'deskripsi',
        'alamat',
        'kontak',
        'gambar',
        'estimasi_investasi',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'status_unggulan' => 'boolean',
        'is_active' => 'boolean',
        'estimasi_investasi' => 'integer',
    ];

    public function sektor(): BelongsTo
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUnggulan($query)
    {
        return $query->where('status_unggulan', true);
    }

    public function scopeBySektor($query, $sektorId)
    {
        return $query->where('sektor_id', $sektorId);
    }

    public function scopeByKecamatan($query, $kecamatanId)
    {
        return $query->where('kecamatan_id', $kecamatanId);
    }

    public function getEstimasiInvestasiFormattedAttribute(): string
    {
        if (!$this->estimasi_investasi) {
            return '-';
        }
        return 'Rp ' . number_format($this->estimasi_investasi, 0, ',', '.');
    }
}