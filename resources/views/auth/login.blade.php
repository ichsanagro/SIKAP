{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-2 gap-8 items-stretch">
  {{-- Panel promosi/brand --}}
  <div class="hidden lg:flex">
    <div class="w-full card bg-gradient-to-br from-unibBlue/10 to-ftOrange/10">
      <h1 class="text-3xl font-extrabold text-unibBlue leading-tight">
        Selamat datang di SIKAP
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

  {{-- Form login --}}
  <div>
    <div class="card">
      <h2 class="text-2xl font-bold text-unibBlue">Masuk</h2>
      <p class="mt-1 text-sm text-gray-600">Gunakan akun kampus Anda untuk mengakses SIKAP.</p>

      @if (session('status'))
        <div class="mt-4 p-3 rounded bg-green-100 text-green-700 text-sm">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4" novalidate>
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

        {{-- Password --}}
        <div>
          <label class="block font-semibold">Kata Sandi</label>
          <div class="mt-1 relative">
            <input
              id="password"
              type="password"
              name="password"
              class="w-full rounded-xl border p-3 pr-12 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
              autocomplete="current-password">
            <button type="button" id="togglePw"
              class="absolute inset-y-0 right-3 my-auto text-sm text-gray-500 hover:text-gray-700">
              Tampilkan
            </button>
          </div>
          @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Remember + Lupa Password --}}
        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            Ingat saya
          </label>

          @if (Route::has('password.request'))
            <a class="text-sm text-unibBlue hover:underline" href="{{ route('password.request') }}">
              Lupa kata sandi?
            </a>
          @endif
        </div>

        {{-- Aksi --}}
        <div class="pt-2 flex flex-col sm:flex-row gap-3">
          <button type="submit" class="btn-primary justify-center w-full sm:w-auto">Masuk</button>

          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-orange justify-center w-full sm:w-auto">
              Daftar Mahasiswa
            </a>
          @endif
        </div>
      </form>

      {{-- Catatan peran (opsional) --}}
      <p class="mt-6 text-xs text-gray-500">
        Perlu bantuan akun? Hubungi Admin Prodi Anda.
      </p>
    </div>
  </div>
</div>

{{-- Toggle password sederhana --}}
<script>
  const pw = document.getElementById('password');
  const btn = document.getElementById('togglePw');
  if (btn && pw) {
    btn.addEventListener('click', () => {
      const isPw = pw.type === 'password';
      pw.type = isPw ? 'text' : 'password';
      btn.textContent = isPw ? 'Sembunyikan' : 'Tampilkan';
    });
  }

  // Custom validation messages in Indonesian
  const inputs = document.querySelectorAll('input[name="email"], input[name="password"]');
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
