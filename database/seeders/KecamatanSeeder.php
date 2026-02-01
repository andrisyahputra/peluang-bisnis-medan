<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        // Increase memory limit for large GeoJSON processing
        ini_set('memory_limit', '512M');

        $path = base_path('Provinsi Sumatera Utara-KECAMATAN.geojson');
        
        if (!file_exists($path)) {
            $this->command->error("File GeoJSON not found at: $path");
            return;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->error("Failed to decode GeoJSON file");
            return;
        }

        $count = 0;
        foreach ($data['features'] as $feature) {
            $props = $feature['properties'];
            
            // Filter for Kota Medan
            if (isset($props['kab_kota']) && $props['kab_kota'] === 'Kota Medan') {
                $namaKecamatan = $props['kecamatan'];
                $geometry = $feature['geometry'];
                
                // Calculate centroid
                $center = $this->calculateCentroid($geometry);
                
                // Find or create kecamatan
                // We prioritize matching by name to preserve existing data (like population)
                $kecamatan = Kecamatan::where('nama_kecamatan', $namaKecamatan)->first();

                $updateData = [
                    'nama_kecamatan' => $namaKecamatan,
                    'geojson_data' => $feature, // Store the full feature as geojson_data
                    'latitude' => $center['lat'],
                    'longitude' => $center['lng'],
                    // Use existing code if available, or use code from GeoJSON
                    'kode_kecamatan' => $kecamatan ? $kecamatan->kode_kecamatan : ($props['kode_kec'] ?? 'MDN-' . strtoupper(substr($namaKecamatan, 0, 3))),
                ];

                if (!$kecamatan) {
                    // Defaults for new records
                    $updateData['luas_wilayah'] = 0;
                    $updateData['jumlah_penduduk'] = 0;
                    $updateData['deskripsi'] = 'Kecamatan di Kota Medan';
                    
                    Kecamatan::create($updateData);
                    $this->command->info("Created: $namaKecamatan");
                } else {
                    $kecamatan->update($updateData);
                    $this->command->info("Updated: $namaKecamatan");
                }
                $count++;
            }
        }

        $this->command->info("Processed $count kecamatan in Kota Medan.");
    }

    private function calculateCentroid(array $geometry): array
    {
        $coordinates = [];
        
        if ($geometry['type'] === 'Polygon') {
            $coordinates = $geometry['coordinates'][0];
        } elseif ($geometry['type'] === 'MultiPolygon') {
            // For MultiPolygon, simplify by taking the first polygon's outer ring
            // Ideally we should calculate area-weighted centroid, but this is a reasonable approximation for districts
            $coordinates = $geometry['coordinates'][0][0];
        }

        if (empty($coordinates)) {
            return ['lat' => 3.5952, 'lng' => 98.6722]; // Default to Medan center
        }

        $minLat = 90;
        $maxLat = -90;
        $minLng = 180;
        $maxLng = -180;

        foreach ($coordinates as $coord) {
            $lng = $coord[0];
            $lat = $coord[1];

            if ($lat < $minLat) $minLat = $lat;
            if ($lat > $maxLat) $maxLat = $lat;
            if ($lng < $minLng) $minLng = $lng;
            if ($lng > $maxLng) $maxLng = $lng;
        }

        return [
            'lat' => ($minLat + $maxLat) / 2,
            'lng' => ($minLng + $maxLng) / 2,
        ];
    }
}