@extends('layouts.admin')

@section('title', 'Manajemen Peluang Bisnis')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Peluang Bisnis</h2>
            <a href="{{ route('admin.peluang-bisnis.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-lg inline-block text-center">
                <i class="fas fa-plus mr-2"></i> Tambah Peluang
            </a>
        </div>

        <!-- Filters -->
        <form method="GET" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama usaha..."
                class="px-4 py-2 border border-gray-300 rounded-lg text-lg">
            <select name="sektor_id" class="px-4 py-2 border border-gray-300 rounded-lg text-lg">
                <option value="">Semua Sektor</option>
                @foreach ($sektors as $sektor)
                <option value="{{ $sektor->id }}" {{ request('sektor_id') == $sektor->id ? 'selected' : '' }}>
                    {{ $sektor->nama_sektor }}
                </option>
                @endforeach
            </select>

            <select name="kecamatan_id" class="px-4 py-2 border border-gray-300 rounded-lg text-lg">
                <option value="">Semua Kecamatan</option>
                @foreach ($kecamatans as $kecamatan)
                <option value="{{ $kecamatan->id }}"
                    {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                    {{ $kecamatan->nama_kecamatan }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-lg">
                <i class="fas fa-search mr-2"></i> Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Nama Usaha</th>
                    <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Sektor</th>
                    <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Kecamatan</th>
                    <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Unggulan</th>
                    <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peluangBisnis as $index => $peluang)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-lg">{{ $peluangBisnis->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        @if ($peluang->gambar)
                        <img src="{{ Storage::url($peluang->gambar) }}" alt="{{ $peluang->nama_usaha }}"
                            class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                        @else
                        <div class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <i class="fas fa-image text-xl"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 text-lg">{{ $peluang->nama_usaha }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg text-white"
                            style="background-color: {{ $peluang->sektor->warna }}">
                            {{ $peluang->sektor->nama_sektor }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-lg">{{ $peluang->kecamatan->nama_kecamatan }}</td>
                    <td class="px-6 py-4 text-center">
                        @if ($peluang->status_unggulan)
                        <span class="text-yellow-500 text-xl"><i class="fas fa-star"></i></span>
                        @else
                        <span class="text-gray-300 text-xl"><i class="far fa-star"></i></span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if ($peluang->is_active)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800">Aktif</span>
                        @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-red-100 text-red-800">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.peluang-bisnis.show', $peluang) }}"
                            class="text-green-600 hover:text-green-800 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.peluang-bisnis.edit', $peluang) }}"
                            class="text-blue-600 hover:text-blue-800 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.peluang-bisnis.destroy', $peluang) }}" method="POST"
                            class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-lg">Belum ada data peluang
                        bisnis</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($peluangBisnis->hasPages())
    <div class="p-6 border-t border-gray-200">
        {{ $peluangBisnis->links() }}
    </div>
    @endif
</div>
@endsection