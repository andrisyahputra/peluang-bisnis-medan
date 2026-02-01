<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PeluangBisnis;
use App\Models\Sektor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function getKecamatans(): JsonResponse
    {
        $kecamatans = Kecamatan::query()
            ->active()
            ->select(['id', 'nama_kecamatan', 'kode_kecamatan', 'geojson_data', 'latitude', 'longitude', 'warna'])
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kecamatans,
        ]);
    }

    public function getSektors(): JsonResponse
    {
        $sektors = Sektor::query()
            ->active()
            ->ordered()
            ->select(['id', 'nama_sektor', 'warna', 'ikon'])
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sektors,
        ]);
    }

    public function getPeluangBisnis(Request $request): JsonResponse
    {
        $query = PeluangBisnis::query()
            ->active()
            ->with(['sektor:id,nama_sektor,warna,ikon', 'kecamatan:id,nama_kecamatan'])
            ->select(['id', 'nama_usaha', 'sektor_id', 'kecamatan_id', 'latitude', 'longitude', 'status_unggulan', 'deskripsi', 'alamat', 'estimasi_investasi', 'gambar']);

        if ($request->has('sektor_id') && $request->sektor_id) {
            $query->where('sektor_id', $request->sektor_id);
        }

        if ($request->has('kecamatan_id') && $request->kecamatan_id) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        if ($request->has('unggulan') && $request->unggulan === 'true') {
            $query->where('status_unggulan', true);
        }

        $peluang = $query->get();

        return response()->json([
            'success' => true,
            'data' => $peluang,
            'total' => $peluang->count(),
        ]);
    }

    public function getStatistik(): JsonResponse
    {
        $totalPeluang = PeluangBisnis::query()->active()->count();
        $totalUnggulan = PeluangBisnis::query()->active()->unggulan()->count();
        $totalSektor = Sektor::query()->active()->count();
        $totalKecamatan = Kecamatan::query()->active()->count();
        $totalInvestasi = PeluangBisnis::query()->active()->sum('estimasi_investasi');

        $peluangPerSektor = Sektor::query()
            ->active()
            ->ordered()
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get()
            ->map(function ($sektor) {
                return [
                    'nama' => $sektor->nama_sektor,
                    'warna' => $sektor->warna,
                    'jumlah' => $sektor->peluang_bisnis_count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'total_peluang' => $totalPeluang,
                'total_unggulan' => $totalUnggulan,
                'total_sektor' => $totalSektor,
                'total_kecamatan' => $totalKecamatan,
                'total_investasi' => $totalInvestasi,
                'peluang_per_sektor' => $peluangPerSektor,
            ],
        ]);
    }
}