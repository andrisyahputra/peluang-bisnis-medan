<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\PeluangBisnis;
use App\Models\Sektor;
use Illuminate\Database\Seeder;

class PeluangBisnisSeeder extends Seeder
{
    public function run(): void
    {
        $sektors = Sektor::all();
        $kecamatans = Kecamatan::all();

        $peluangData = [
            ['nama_usaha' => 'Industri Pengolahan Ikan', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Belawan', 'unggulan' => true, 'investasi' => 500000000],
            ['nama_usaha' => 'Pabrik Roti dan Kue', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Helvetia', 'unggulan' => true, 'investasi' => 300000000],
            ['nama_usaha' => 'Industri Olahan Buah', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Tuntungan', 'unggulan' => false, 'investasi' => 250000000],
            ['nama_usaha' => 'Sentra Makanan Ringan', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Amplas', 'unggulan' => false, 'investasi' => 150000000],
            ['nama_usaha' => 'Industri Minuman Kemasan', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Deli', 'unggulan' => true, 'investasi' => 750000000],
            ['nama_usaha' => 'Pengolahan Kopi Premium', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Johor', 'unggulan' => false, 'investasi' => 200000000],
            ['nama_usaha' => 'Industri Tahu Tempe Modern', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Denai', 'unggulan' => false, 'investasi' => 100000000],
            ['nama_usaha' => 'Konveksi Pakaian Jadi', 'sektor' => 'Sandang', 'kecamatan' => 'Medan Petisah', 'unggulan' => true, 'investasi' => 400000000],
            ['nama_usaha' => 'Batik Medan', 'sektor' => 'Sandang', 'kecamatan' => 'Medan Kota', 'unggulan' => true, 'investasi' => 350000000],
            ['nama_usaha' => 'Industri Sepatu', 'sektor' => 'Sandang', 'kecamatan' => 'Medan Area', 'unggulan' => false, 'investasi' => 280000000],
            ['nama_usaha' => 'Bordir dan Sulam', 'sektor' => 'Sandang', 'kecamatan' => 'Medan Maimun', 'unggulan' => false, 'investasi' => 120000000],
            ['nama_usaha' => 'Pabrik Komponen Otomotif', 'sektor' => 'Manufaktur', 'kecamatan' => 'Medan Deli', 'unggulan' => true, 'investasi' => 2000000000],
            ['nama_usaha' => 'Industri Plastik', 'sektor' => 'Manufaktur', 'kecamatan' => 'Medan Labuhan', 'unggulan' => false, 'investasi' => 1500000000],
            ['nama_usaha' => 'Pabrik Furniture', 'sektor' => 'Manufaktur', 'kecamatan' => 'Medan Marelan', 'unggulan' => false, 'investasi' => 800000000],
            ['nama_usaha' => 'Industri Logam', 'sektor' => 'Manufaktur', 'kecamatan' => 'Medan Belawan', 'unggulan' => true, 'investasi' => 1200000000],
            ['nama_usaha' => 'Tech Startup Hub', 'sektor' => 'Teknologi Informasi', 'kecamatan' => 'Medan Baru', 'unggulan' => true, 'investasi' => 500000000],
            ['nama_usaha' => 'Data Center', 'sektor' => 'Teknologi Informasi', 'kecamatan' => 'Medan Polonia', 'unggulan' => false, 'investasi' => 3000000000],
            ['nama_usaha' => 'Software House', 'sektor' => 'Teknologi Informasi', 'kecamatan' => 'Medan Selayang', 'unggulan' => false, 'investasi' => 250000000],
            ['nama_usaha' => 'Industri Keramik Modern', 'sektor' => 'Material Maju', 'kecamatan' => 'Medan Tuntungan', 'unggulan' => false, 'investasi' => 600000000],
            ['nama_usaha' => 'Pabrik Kaca', 'sektor' => 'Material Maju', 'kecamatan' => 'Medan Sunggal', 'unggulan' => false, 'investasi' => 900000000],
            ['nama_usaha' => 'Klinik Kecantikan', 'sektor' => 'Kesehatan & Kosmetik', 'kecamatan' => 'Medan Petisah', 'unggulan' => true, 'investasi' => 450000000],
            ['nama_usaha' => 'Pabrik Kosmetik Herbal', 'sektor' => 'Kesehatan & Kosmetik', 'kecamatan' => 'Medan Helvetia', 'unggulan' => false, 'investasi' => 350000000],
            ['nama_usaha' => 'Apotek Modern', 'sektor' => 'Kesehatan & Kosmetik', 'kecamatan' => 'Medan Timur', 'unggulan' => false, 'investasi' => 200000000],
            ['nama_usaha' => 'Jasa Logistik', 'sektor' => 'Jasa Lainnya', 'kecamatan' => 'Medan Belawan', 'unggulan' => true, 'investasi' => 1000000000],
            ['nama_usaha' => 'Event Organizer', 'sektor' => 'Jasa Lainnya', 'kecamatan' => 'Medan Kota', 'unggulan' => false, 'investasi' => 150000000],
            ['nama_usaha' => 'Resto Padang Modern', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Perjuangan', 'unggulan' => false, 'investasi' => 180000000],
            ['nama_usaha' => 'Warung Kopi Specialty', 'sektor' => 'Pangan', 'kecamatan' => 'Medan Tembung', 'unggulan' => false, 'investasi' => 120000000],
            ['nama_usaha' => 'Percetakan Digital', 'sektor' => 'Manufaktur', 'kecamatan' => 'Medan Barat', 'unggulan' => false, 'investasi' => 280000000],
        ];

        foreach ($peluangData as $data) {
            $sektor = $sektors->where('nama_sektor', $data['sektor'])->first();
            $kecamatan = $kecamatans->where('nama_kecamatan', $data['kecamatan'])->first();

            if ($sektor && $kecamatan) {
                PeluangBisnis::query()->create([
                    'nama_usaha' => $data['nama_usaha'],
                    'sektor_id' => $sektor->id,
                    'kecamatan_id' => $kecamatan->id,
                    'latitude' => $kecamatan->latitude + (rand(-50, 50) / 10000),
                    'longitude' => $kecamatan->longitude + (rand(-50, 50) / 10000),
                    'status_unggulan' => $data['unggulan'],
                    'estimasi_investasi' => $data['investasi'],
                    'deskripsi' => 'Peluang bisnis ' . $data['nama_usaha'] . ' di ' . $data['kecamatan'] . ' dengan prospek yang menjanjikan.',
                    'alamat' => 'Jl. Utama No. ' . rand(1, 100) . ', ' . $data['kecamatan'],
                    'is_active' => true,
                ]);
            }
        }
    }
}