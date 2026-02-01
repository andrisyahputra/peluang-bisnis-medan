<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sektor;
use Illuminate\Http\Request;

class SektorController extends Controller
{
    public function index()
    {
        $sektors = Sektor::query()
            ->withCount('peluangBisnis')
            ->ordered()
            ->paginate(10);

        return view('admin.sektor.index', compact('sektors'));
    }

    public function create()
    {
        return view('admin.sektor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sektor' => 'required|string|max:255|unique:sektors,nama_sektor',
            'warna' => 'required|string|max:7',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Sektor::query()->create($validated);

        return redirect()->route('admin.sektor.index')
            ->with('success', 'Sektor berhasil ditambahkan.');
    }

    public function edit(Sektor $sektor)
    {
        return view('admin.sektor.edit', compact('sektor'));
    }

    public function update(Request $request, Sektor $sektor)
    {
        $validated = $request->validate([
            'nama_sektor' => 'required|string|max:255|unique:sektors,nama_sektor,' . $sektor->id,
            'warna' => 'required|string|max:7',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $sektor->update($validated);

        return redirect()->route('admin.sektor.index')
            ->with('success', 'Sektor berhasil diperbarui.');
    }

    public function destroy(Sektor $sektor)
    {
        if ($sektor->peluangBisnis()->count() > 0) {
            return redirect()->route('admin.sektor.index')
                ->with('error', 'Sektor tidak dapat dihapus karena masih memiliki peluang bisnis terkait.');
        }

        $sektor->delete();

        return redirect()->route('admin.sektor.index')
            ->with('success', 'Sektor berhasil dihapus.');
    }
}