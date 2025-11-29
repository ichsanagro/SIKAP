{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-2 gap-8 items-stretch">
  {{-- Panel promosi/brand --}}
  <div class="hidden lg:flex">
    <div class="w-full card bg-gradient-to-br from-unibBlue/10 to-ftOrange/10">
      <h1 class="text-3xl font-extrabold text-unibBlue leading-tight">
        Reset Kata Sandi SIKAP
      </h1>
      <p class="mt-3 text-gray-600">
        Portal Kerja Praktik: ajukan judul, pilih tempat magang, catat bimbingan & aktivitas,
        unggah laporan, hingga isi kuesioner—semuanya dalam satu tempat.
      </p>

      <ul class="mt-6 space-y-3 text-gray-700">
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-unibBlue"></span>
          Verifikasi Prodi & penugasan pembimbing otomatis
        </li>
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-ftOrange"></span>
          Log bimbingan & aktivitas lapangan terstruktur
        </li>
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-unibBlue"></span>
          Unggah laporan & kuesioner pasca-KP
        </li>
      </ul>
    </div>
  </div>

  {{-- Form forgot password --}}
  <div>
    <div class="card">
      <h2 class="text-2xl font-bold text-unibBlue">Lupa Kata Sandi?</h2>
      <p class="mt-1 text-sm text-gray-600">Jangan khawatir! Masukkan alamat email Anda dan kami akan mengirimkan tautan reset kata sandi.</p>

      @if (session('status'))
        <div class="mt-4 p-3 rounded bg-green-100 text-green-700 text-sm">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4" novalidate>
        @csrf

        {{-- Email --}}
        <div>
          <label class="block font-semibold">Email</label>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
            autofocus
            autocomplete="username">
          @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Aksi --}}
        <div class="pt-2">
          <button type="submit" class="btn-primary justify-center w-full">Kirim Tautan Reset Kata Sandi</button>
        </div>
      </form>

      {{-- Catatan --}}
      <p class="mt-6 text-xs text-gray-500">
        Perlu bantuan akun? Hubungi Admin Prodi Anda.
      </p>

      {{-- Kembali ke login --}}
      <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-unibBlue hover:underline">Kembali ke Halaman Masuk</a>
      </div>
    </div>
  </div>
</div>

{{-- Custom validation messages in Indonesian --}}
<script>
  const inputs = document.querySelectorAll('input[name="email"]');
  inputs.forEach(input => {
    input.addEventListener('invalid', function(event) {
      if (input.validity.valueMissing) {
        input.setCustomValidity('Kolom ini wajib diisi.');
      } else {
        input.setCustomValidity('');
      }
    });
    input.addEventListener('input', function() {
      input.setCustomValidity('');
    });
  });
</script>
@endsection
