@extends('layouts.app')
@section('content')
@include('student.partials.nav')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Unggah Laporan Akhir</h2>

  <form method="POST" action="{{ route('reports.store', $kp) }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <p class="text-sm text-gray-600">Format file: PDF, maks 20MB.</p>
    <input type="file" name="file" accept="application/pdf" required>
    @error('file') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

    <div class="pt-2">
      <button class="btn-primary">Kirim Laporan</button>
    </div>
  </form>
</div>
@endsection
