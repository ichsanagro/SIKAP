@extends('layouts.app')
@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Tambah Aktivitas Lapangan</h2>

  @if($myKps->isEmpty())
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
      <p>Anda tidak dapat mencatat aktivitas lapangan saat ini. Mohon pastikan judul KP telah disetujui oleh Dosen Pembimbing.</p>
    </div>
  @else
  <form method="POST" action="{{ route('activity-logs.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block font-semibold">Pilih KP</label>
      <select name="kp_application_id" class="mt-1 w-full border rounded-xl p-3" required>
        @foreach($myKps as $k)
          <option value="{{ $k->id }}">{{ $k->title }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block font-semibold">Tanggal</label>
      <input type="date" name="date" class="mt-1 w-full border rounded-xl p-3" required oninvalid="this.setCustomValidity('Tanggal wajib diisi.')" oninput="this.setCustomValidity('')">
    </div>
    <div>
      <label class="block font-semibold">Deskripsi</label>
      <textarea name="description" class="mt-1 w-full border rounded-xl p-3" rows="4" required oninvalid="this.setCustomValidity('Silakan isi kolom ini.')" oninput="this.setCustomValidity('')"></textarea>
    </div>
    <div>
      <label class="block font-semibold">Link Drive (opsional)</label>
      <input type="url" name="drive_link" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3">
    </div>
    <div class="pt-2">
      <button class="btn-primary">Simpan</button>
    </div>
  </form>
  @endif
</div>
@endsection
