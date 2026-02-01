<?php

namespace Database\Seeders;

use App\Models\Sektor;
use Illuminate\Database\Seeder;

class SektorSeeder extends Seeder
{
    public function run(): void
    {
        $sektors = [
            [
                'nama_sektor' => 'Pangan',
                'warna' => '#22c55e',
                'ikon' => 'fa-seedling',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang produksi, pengolahan, dan distribusi bahan pangan',
                'urutan' => 1,
            ],
            [
                'nama_sektor' => 'Sandang',
                'warna' => '#f59e0b',
                'ikon' => 'fa-shirt',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang tekstil, pakaian, dan aksesori fashion',
                'urutan' => 2,
            ],
            [
                'nama_sektor' => 'Manufaktur',
                'warna' => '#3b82f6',
                'ikon' => 'fa-industry',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang produksi dan pengolahan barang industri',
                'urutan' => 3,
            ],
            [
                'nama_sektor' => 'Teknologi Informasi',
                'warna' => '#8b5cf6',
                'ikon' => 'fa-microchip',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang teknologi, software, dan layanan digital',
                'urutan' => 4,
            ],
            [
                'nama_sektor' => 'Material Maju',
                'warna' => '#06b6d4',
                'ikon' => 'fa-atom',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang material canggih dan inovasi bahan',
                'urutan' => 5,
            ],
            [
                'nama_sektor' => 'Kesehatan & Kosmetik',
                'warna' => '#ec4899',
                'ikon' => 'fa-heart-pulse',
                'deskripsi' => 'Sektor usaha yang bergerak di bidang kesehatan, farmasi, dan produk kosmetik',
                'urutan' => 6,
            ],
            [
                'nama_sektor' => 'Jasa Lainnya',
                'warna' => '#f97316',
                'ikon' => 'fa-briefcase',
                'deskripsi' => 'Sektor usaha jasa yang tidak termasuk dalam kategori lainnya',
                'urutan' => 7,
            ],
        ];

        foreach ($sektors as $sektor) {
            Sektor::query()->create($sektor);
        }
    }
}