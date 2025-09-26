@extends('layouts.app')

@section('content')
  <section class="grid md:grid-cols-2 gap-8 items-center">
    <div>
      <h1 class="text-4xl font-extrabold text-unibBlue leading-tight">
        Sistem Informasi Manajemen Kerja Praktek
      </h1>
      <p class="mt-4 text-lg text-gray-600">
        Ajukan judul, pilih tempat magang (opsi 1/2 dari Prodi atau cari sendiri), catat bimbingan & aktivitas, unggah laporan, dan isi kuesioner—semua dalam satu portal.
      </p>
      <div class="mt-6 flex gap-3">
        <a href="{{ route('register') }}" class="btn-orange">Daftar Mahasiswa</a>
        <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
      </div>
    </div>
    <div class="bg-white card">
      <h3 class="text-xl font-semibold mb-3">Kelebihan</h3>
      <ul class="list-disc pl-6 space-y-1 text-gray-700">
        <li>Alur verifikasi Prodi & penugasan pembimbing</li>
        <li>Bimbingan terstruktur & jejak aktivitas lapangan</li>
        <li>Laporan & kuesioner pasca-KP tersentral</li>
      </ul>
    </div>
  </section>
@endsection
