@extends('layouts.app')
@section('content')
@include('student.partials.nav')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Tambah Catatan Bimbingan</h2>

  <form method="POST" action="{{ route('mentoring-logs.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block font-semibold">Pilih KP</label>
      <select name="kp_application_id" class="mt-1 w-full border rounded-xl p-3" required>
        @foreach($myKps as $k)
          <option value="{{ $k->id }}">{{ $k->title }}</option>
        @endforeach
      </select>
      @error('kp_application_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block font-semibold">Tanggal</label>
      <input type="date" name="date" class="mt-1 w-full border rounded-xl p-3" required>
      @error('date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block font-semibold">Topik</label>
      <input name="topic" class="mt-1 w-full border rounded-xl p-3" required>
      @error('topic') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block font-semibold">Catatan</label>
      <textarea name="notes" class="mt-1 w-full border rounded-xl p-3" rows="4"></textarea>
    </div>
    <div>
      <label class="block font-semibold">Lampiran (opsional)</label>
      <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png" class="mt-1">
    </div>
    <div class="pt-2">
      <button class="btn-primary">Simpan</button>
    </div>
  </form>
</div>
@endsection
