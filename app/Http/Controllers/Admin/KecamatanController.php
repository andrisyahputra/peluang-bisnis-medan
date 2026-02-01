<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::query()
            ->withCount('peluangBisnis')
            ->orderBy('nama_kecamatan')
            ->paginate(10);

        return view('admin.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('admin.kecamatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'kode_kecamatan' => 'required|string|max:20|unique:kecamatans,kode_kecamatan',
            'geojson_data' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'luas_wilayah' => 'nullable|integer|min:0',
            'jumlah_penduduk' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Parse GeoJSON from string to array
        if (!empty($validated['geojson_data'])) {
            $geojson = json_decode($validated['geojson_data'], true);
            if ($geojson) {
                // Add warna to properties
                $geojson['properties']['warna'] = $validated['warna'] ?? '#3388ff';
                $validated['geojson_data'] = $geojson;
            }
        } else {
            $validated['geojson_data'] = null;
        }

        Kecamatan::query()->create($validated);

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'kode_kecamatan' => 'required|string|max:20|unique:kecamatans,kode_kecamatan,' . $kecamatan->id,
            'geojson_data' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'luas_wilayah' => 'nullable|integer|min:0',
            'jumlah_penduduk' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Parse GeoJSON from string to array
        if (!empty($validated['geojson_data'])) {
            $geojson = json_decode($validated['geojson_data'], true);
            if ($geojson) {
                // Add warna to properties
                $geojson['properties']['warna'] = $validated['warna'] ?? '#3388ff';
                $validated['geojson_data'] = $geojson;
            }
        } else {
            $validated['geojson_data'] = null;
        }

        // dd($validated);

        $kecamatan->update($validated);

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        if ($kecamatan->peluangBisnis()->count() > 0) {
            return redirect()->route('admin.kecamatan.index')
                ->with('error', 'Kecamatan tidak dapat dihapus karena masih memiliki peluang bisnis terkait.');
        }

        $kecamatan->delete();

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }
}
