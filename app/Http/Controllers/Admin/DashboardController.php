<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PeluangBisnis;
use App\Models\Sektor;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeluang = PeluangBisnis::query()->count();
        $totalUnggulan = PeluangBisnis::query()->unggulan()->count();
        $totalSektor = Sektor::query()->count();
        $totalKecamatan = Kecamatan::query()->count();
        $totalAdmin = User::query()->admin()->count();
        $totalInvestasi = PeluangBisnis::query()->active()->sum('estimasi_investasi');

        $peluangTerbaru = PeluangBisnis::query()
            ->with(['sektor', 'kecamatan'])
            ->latest()
            ->take(5)
            ->get();

        $peluangPerSektor = Sektor::query()
            ->withCount('peluangBisnis')
            ->ordered()
            ->get();

        return view('admin.dashboard', compact(
            'totalPeluang',
            'totalUnggulan',
            'totalSektor',
            'totalKecamatan',
            'totalAdmin',
            'totalInvestasi',
            'peluangTerbaru',
            'peluangPerSektor'
        ));
    }
}