@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Detail Mahasiswa KP</h1>

<div class="grid md:grid-cols-2 gap-4 text-sm">
  <div class="p-4 border rounded">
    <h2 class="font-semibold mb-2">Mahasiswa</h2>
    <p>Nama: {{ optional($application->student)->name ?? '-' }}</p>
    <p>NIM: {{ optional($application->student)->nim ?? '-' }}</p>
    <p>Email: {{ optional($application->student)->email ?? '-' }}</p>
  </div>
  <div class="p-4 border rounded">
    <h2 class="font-semibold mb-2">Instansi</h2>
    <p>Nama: {{ optional($application->company)->name ?? '-' }}</p>
    <p>Alamat: {{ optional($application->company)->address ?? '-' }}</p>
    <p>Periode: {{ $application->period ?? '-' }}</p>
    <p>Status: {{ $application->status ?? '-' }}</p>
  </div>
</div>

<div class="mt-4 space-x-2">
  <a href="{{ route('field.students.index') }}" class="text-blue-600">Kembali</a>
  <form action="{{ route('field.students.destroy', $application) }}" method="POST" class="inline"
        onsubmit="return confirm('Unassign mahasiswa ini dari Anda?')">
    @csrf @method('DELETE')
    <button class="text-red-600">Hapus (Unassign)</button>
  </form>
</div>
@endsection
