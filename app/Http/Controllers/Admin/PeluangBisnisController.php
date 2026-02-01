<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PeluangBisnis;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeluangBisnisController extends Controller
{
    public function index(Request $request)
    {
        $query = PeluangBisnis::query()->with(['sektor', 'kecamatan']);

        if ($request->filled('sektor_id')) {
            $query->where('sektor_id', $request->sektor_id);
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        if ($request->filled('status_unggulan')) {
            $query->where('status_unggulan', $request->status_unggulan === '1');
        }

        if ($request->filled('search')) {
            $query->where('nama_usaha', 'like', '%' . $request->search . '%');
        }

        $peluangBisnis = $query->latest()->paginate(10)->withQueryString();
        $sektors = Sektor::query()->active()->ordered()->get();
        $kecamatans = Kecamatan::query()->active()->orderBy('nama_kecamatan')->get();

        return view('admin.peluang-bisnis.index', compact('peluangBisnis', 'sektors', 'kecamatans'));
    }

    public function create()
    {
        $sektors = Sektor::query()->active()->ordered()->get();
        $kecamatans = Kecamatan::query()->active()->orderBy('nama_kecamatan')->get();

        return view('admin.peluang-bisnis.create', compact('sektors', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'sektor_id' => 'required|exists:sektors,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status_unggulan' => 'boolean',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:500',
            'kontak' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estimasi_investasi' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['status_unggulan'] = $request->has('status_unggulan');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('peluang-bisnis', 'public');
        }

        PeluangBisnis::query()->create($validated);

        return redirect()->route('admin.peluang-bisnis.index')
            ->with('success', 'Peluang bisnis berhasil ditambahkan.');
    }

    public function show(PeluangBisnis $peluangBisni)
    {
        $peluangBisni->load(['sektor', 'kecamatan']);
        return view('admin.peluang-bisnis.show', ['peluangBisnis' => $peluangBisni]);
    }

    public function edit(PeluangBisnis $peluangBisni)
    {
        $sektors = Sektor::query()->active()->ordered()->get();
        $kecamatans = Kecamatan::query()->active()->orderBy('nama_kecamatan')->get();

        return view('admin.peluang-bisnis.edit', [
            'peluangBisnis' => $peluangBisni,
            'sektors' => $sektors,
            'kecamatans' => $kecamatans,
        ]);
    }

    public function update(Request $request, PeluangBisnis $peluangBisni)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'sektor_id' => 'required|exists:sektors,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status_unggulan' => 'boolean',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:500',
            'kontak' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estimasi_investasi' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['status_unggulan'] = $request->has('status_unggulan');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($peluangBisni->gambar) {
                Storage::disk('public')->delete($peluangBisni->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('peluang-bisnis', 'public');
        }

        $peluangBisni->update($validated);

        return redirect()->route('admin.peluang-bisnis.index')
            ->with('success', 'Peluang bisnis berhasil diperbarui.');
    }

    public function destroy(PeluangBisnis $peluangBisni)
    {
        if ($peluangBisni->gambar) {
            Storage::disk('public')->delete($peluangBisni->gambar);
        }
        $peluangBisni->delete();

        return redirect()->route('admin.peluang-bisnis.index')
            ->with('success', 'Peluang bisnis berhasil dihapus.');
    }
}
