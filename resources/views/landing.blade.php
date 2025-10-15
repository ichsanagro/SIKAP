@extends('layouts.app')

@section('content')
  {{-- Hero Section --}}
  <section class="relative bg-gradient-to-br from-unibBlue/10 via-white to-ftOrange/10 py-16 lg:py-24">
    <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center">
      <div class="text-center lg:text-left">
        <h1 class="text-4xl lg:text-6xl font-extrabold text-unibBlue leading-tight">
          Sistem Informasi Manajemen Kerja Praktek
        </h1>
        <p class="mt-6 text-lg lg:text-xl text-gray-600 leading-relaxed">
          Ajukan judul, pilih tempat magang (opsi 1/2 dari Prodi atau cari sendiri), catat bimbingan & aktivitas, unggah laporan, dan isi kuesioner—semua dalam satu portal.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <a href="{{ route('register') }}" class="btn-orange text-center">Daftar Mahasiswa</a>
          <a href="{{ route('login') }}" class="btn-primary text-center">Masuk</a>
        </div>
      </div>
      <div class="hidden lg:block">
        <div class="bg-white card p-8 shadow-2xl">
          <div class="text-center">
            <div class="w-16 h-16 bg-unibBlue rounded-full mx-auto mb-4 flex items-center justify-center">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-unibBlue mb-2">Mudah & Terintegrasi</h3>
            <p class="text-gray-600">Semua proses KP dalam satu platform yang user-friendly.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Features Section --}}
  <section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-4xl font-bold text-unibBlue">Fitur Unggulan</h2>
        <p class="mt-4 text-lg text-gray-600">Platform lengkap untuk mendukung proses Kerja Praktek Anda.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="card text-center p-6">
          <div class="w-12 h-12 bg-unibBlue rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Verifikasi Prodi</h3>
          <p class="text-gray-600">Alur verifikasi otomatis dari Program Studi dan penugasan pembimbing yang efisien.</p>
        </div>
        <div class="card text-center p-6">
          <div class="w-12 h-12 bg-ftOrange rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Bimbingan Terstruktur</h3>
          <p class="text-gray-600">Log bimbingan dan jejak aktivitas lapangan yang terorganisir dengan baik.</p>
        </div>
        <div class="card text-center p-6">
          <div class="w-12 h-12 bg-unibBlue rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
              <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Laporan & Kuesioner</h3>
          <p class="text-gray-600">Unggah laporan dan isi kuesioner pasca-KP dalam satu tempat yang tersentral.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Stats/Testimonials Section --}}
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-4xl font-bold text-unibBlue">Dipercaya Oleh</h2>
        <p class="mt-4 text-lg text-gray-600">Bergabunglah dengan ribuan mahasiswa yang telah menggunakan SIKAP.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-8 text-center">
        <div>
          <div class="text-4xl font-bold text-ftOrange mb-2">500+</div>
          <p class="text-gray-600">Mahasiswa Terdaftar</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-unibBlue mb-2">50+</div>
          <p class="text-gray-600">Tempat Magang</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-ftOrange mb-2">100%</div>
          <p class="text-gray-600">Proses Terintegrasi</p>
        </div>
      </div>
      <div class="mt-12 grid md:grid-cols-2 gap-8">
        <div class="card p-6">
          <p class="text-gray-600 italic">"SIKAP sangat memudahkan proses KP saya. Semua dalam satu aplikasi!"</p>
          <div class="mt-4 flex items-center">
            <div class="w-10 h-10 bg-unibBlue rounded-full flex items-center justify-center text-white font-bold mr-3">A</div>
            <div>
              <p class="font-semibold">Ahmad S.</p>
              <p class="text-sm text-gray-500">Mahasiswa Teknik Informatika</p>
            </div>
          </div>
        </div>
        <div class="card p-6">
          <p class="text-gray-600 italic">"Bimbingan jadi lebih terstruktur dan mudah dilacak."</p>
          <div class="mt-4 flex items-center">
            <div class="w-10 h-10 bg-ftOrange rounded-full flex items-center justify-center text-white font-bold mr-3">B</div>
            <div>
              <p class="font-semibold">Budi R.</p>
              <p class="text-sm text-gray-500">Mahasiswa Teknik Sipil</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA Section --}}
  <section class="py-16 bg-unibBlue text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-3xl lg:text-4xl font-bold mb-4">Siap Mulai Kerja Praktek Anda?</h2>
      <p class="text-lg mb-8">Daftar sekarang dan nikmati pengalaman KP yang lebih mudah dan efisien.</p>
      <a href="{{ route('register') }}" class="btn-orange inline-block">Daftar Sekarang</a>
    </div>
  </section>
@endsection
