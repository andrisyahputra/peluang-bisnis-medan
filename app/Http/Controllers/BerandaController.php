<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PeluangBisnis;
use App\Models\Sektor;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $sektors = Sektor::query()
            ->active()
            ->ordered()
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        $totalPeluang = PeluangBisnis::query()->active()->count();
        $totalUnggulan = PeluangBisnis::query()->active()->unggulan()->count();

        return view('public.beranda', compact('sektors', 'totalPeluang', 'totalUnggulan'));
    }

    public function profilKota()
    {
        $kecamatans = Kecamatan::query()
            ->active()
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('nama_kecamatan')
            ->get();

        $totalPenduduk = $kecamatans->sum('jumlah_penduduk');
        $totalLuas = $kecamatans->sum('luas_wilayah');

        return view('public.profil-kota', compact('kecamatans', 'totalPenduduk', 'totalLuas'));
    }

    public function potensiInvestasi()
    {
        $sektors = Sektor::query()
            ->active()
            ->ordered()
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        $totalInvestasi = PeluangBisnis::query()->active()->sum('estimasi_investasi');

        return view('public.potensi-investasi', compact('sektors', 'totalInvestasi'));
    }

    public function peluangBisnis(Request $request)
    {
        $sektors = Sektor::query()
            ->active()
            ->ordered()
            ->withCount([
                'peluangBisnis' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        $kecamatans = Kecamatan::query()->active()->orderBy('nama_kecamatan')->get();
        $totalUnggulan = PeluangBisnis::query()->active()->unggulan()->count();
        $totalSemua = PeluangBisnis::query()->active()->count();

        return view('public.peluang-bisnis', compact('sektors', 'kecamatans', 'totalUnggulan', 'totalSemua'));
    }

    public function insentif()
    {
        return view('public.insentif');
    }

    public function rdtrInteraktif()
    {
        $kecamatans = Kecamatan::query()->active()->get();
        return view('public.rdtr-interaktif', compact('kecamatans'));
    }

    public function petaInvestasi()
    {
        $sektors = Sektor::query()->active()->ordered()->get();
        $kecamatans = Kecamatan::query()->active()->get();
        return view('public.peta-investasi', compact('sektors', 'kecamatans'));
    }
}