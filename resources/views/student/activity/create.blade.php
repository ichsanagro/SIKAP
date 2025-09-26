@extends('layouts.app')
@section('content')
@include('student.partials.nav')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Tambah Aktivitas Lapangan</h2>

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
      <input type="date" name="date" class="mt-1 w-full border rounded-xl p-3" required>
    </div>
    <div>
      <label class="block font-semibold">Deskripsi</label>
      <textarea name="description" class="mt-1 w-full border rounded-xl p-3" rows="4" required></textarea>
    </div>
    <div>
      <label class="block font-semibold">Foto (opsional)</label>
      <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="mt-1">
    </div>
    <div class="pt-2">
      <button class="btn-primary">Simpan</button>
    </div>
  </form>
</div>
@endsection
