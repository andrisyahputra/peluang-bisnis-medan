@extends('layouts.public')

@section('title', 'Insentif Investasi')
@section('description', 'Informasi tentang berbagai insentif dan kemudahan yang tersedia bagi investor.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Insentif Investasi</h1>
        <p class="text-xl text-gray-600 mb-8">Berbagai kemudahan dan insentif untuk mendukung investasi Anda</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="w-16 h-16 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                    <i class="fas fa-percentage text-blue-500 text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2">Keringanan Pajak</h3>
                <p class="text-lg text-gray-600">Investor dapat menikmati keringanan pajak daerah untuk periode tertentu
                    sesuai dengan ketentuan yang berlaku.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="w-16 h-16 rounded-xl bg-green-100 flex items-center justify-center mb-4">
                    <i class="fas fa-file-signature text-green-500 text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2">Kemudahan Perizinan</h3>
                <p class="text-lg text-gray-600">Proses perizinan yang lebih cepat dan terintegrasi melalui sistem Online
                    Single Submission (OSS).</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="w-16 h-16 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                    <i class="fas fa-hands-helping text-purple-500 text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2">Pendampingan Investasi</h3>
                <p class="text-lg text-gray-600">Tim khusus yang siap membantu investor dalam proses investasi dari awal
                    hingga operasional.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="w-16 h-16 rounded-xl bg-orange-100 flex items-center justify-center mb-4">
                    <i class="fas fa-map-marked-alt text-orange-500 text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2">Lokasi Strategis</h3>
                <p class="text-lg text-gray-600">Akses ke kawasan industri dan infrastruktur pendukung yang memadai untuk
                    kegiatan bisnis.</p>
            </div>
        </div>

        <div class="bg-gradient-to-r from-accent-400 to-accent-500 rounded-2xl p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Tertarik Berinvestasi?</h2>
            <p class="text-white/90 mb-6 text-xl">Hubungi Dinas Penanaman Modal untuk konsultasi lebih lanjut</p>
            <a href="mailto:dpmptsp@pemkot.go.id"
                class="bg-white text-accent-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition inline-block">
                <i class="fas fa-envelope mr-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
@endsection
