{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-2 gap-8 items-stretch">
  {{-- Panel brand/teaser (kiri) --}}
  <div class="hidden lg:flex">
    <div class="w-full card bg-gradient-to-br from-unibBlue/10 to-ftOrange/10">
      <h1 class="text-3xl font-extrabold text-unibBlue leading-tight">
        Buat Akun SIKAP
      </h1>
      <p class="mt-3 text-gray-600">
        Akses portal Kerja Praktek untuk ajukan judul, pilih tempat, catat bimbingan & aktivitas,
        unggah laporan, hingga isi kuesioner — semuanya terintegrasi.
      </p>

      <ul class="mt-6 space-y-3 text-gray-700">
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-unibBlue"></span>
          Verifikasi Prodi & penugasan pembimbing
        </li>
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-ftOrange"></span>
          Log bimbingan & aktivitas yang tertata
        </li>
        <li class="flex items-start gap-3">
          <span class="mt-1 inline-block w-2.5 h-2.5 rounded-full bg-unibBlue"></span>
          Unggah laporan & isi kuesioner pasca-KP
        </li>
      </ul>
    </div>
  </div>

  {{-- Form Register (kanan) --}}
  <div>
    <div class="card">
      <h2 class="text-2xl font-bold text-unibBlue">Daftar Akun</h2>
      <p class="mt-1 text-sm text-gray-600">Silakan isi data diri Anda dengan benar.</p>

      <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
          <label class="block font-semibold">Nama Lengkap</label>
          <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
            required
            autocomplete="name">
          @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- NIM (opsional: bisa dibuat required) --}}
        <div>
          <label class="block font-semibold">NIM</label>
          <input
            type="text"
            name="nim"
            value="{{ old('nim') }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
            required>
          @error('nim') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
          <label class="block font-semibold">Email</label>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
            required
            autocomplete="username">
          @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
          <label class="block font-semibold">Kata Sandi</label>
          <div class="mt-1 relative">
            <input
              id="password"
              type="password"
              name="password"
              class="w-full rounded-xl border p-3 pr-12 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
              required
              autocomplete="new-password">
            <button type="button" id="togglePw"
              class="absolute inset-y-0 right-3 my-auto text-sm text-gray-500 hover:text-gray-700">
              Tampilkan
            </button>
          </div>
          @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
          <label class="block font-semibold">Konfirmasi Kata Sandi</label>
          <div class="mt-1 relative">
            <input
              id="password_confirmation"
              type="password"
              name="password_confirmation"
              class="w-full rounded-xl border p-3 pr-12 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
              required
              autocomplete="new-password">
            <button type="button" id="togglePw2"
              class="absolute inset-y-0 right-3 my-auto text-sm text-gray-500 hover:text-gray-700">
              Tampilkan
            </button>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="pt-2 flex flex-col sm:flex-row gap-3">
          <button type="submit" class="btn-primary justify-center w-full sm:w-auto">Buat Akun</button>
          <a href="{{ route('login') }}" class="btn-orange justify-center w-full sm:w-auto">Sudah punya akun? Masuk</a>
        </div>
      </form>

      <p class="mt-6 text-xs text-gray-500">
        Dengan mendaftar, Anda menyetujui ketentuan yang berlaku di lingkungan kampus.
      </p>
    </div>
  </div>
</div>

{{-- Toggle password sederhana --}}
<script>
  const pw = document.getElementById('password');
  const pw2 = document.getElementById('password_confirmation');
  const btn = document.getElementById('togglePw');
  const btn2 = document.getElementById('togglePw2');

  if (btn && pw) {
    btn.addEventListener('click', () => {
      const isPw = pw.type === 'password';
      pw.type = isPw ? 'text' : 'password';
      btn.textContent = isPw ? 'Sembunyikan' : 'Tampilkan';
    });
  }
  if (btn2 && pw2) {
    btn2.addEventListener('click', () => {
      const isPw = pw2.type === 'password';
      pw2.type = isPw ? 'text' : 'password';
      btn2.textContent = isPw ? 'Sembunyikan' : 'Tampilkan';
    });
  }
</script>
@endsection
