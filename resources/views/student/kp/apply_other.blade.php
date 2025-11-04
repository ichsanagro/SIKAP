@extends('layouts.app')

@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Form Pengajuan Instansi Lain</h2>

  <form method="POST" action="{{ route('kp.apply.other.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label class="block font-semibold">Nama Perusahaan</label>
      <input name="custom_company_name" value="{{ old('custom_company_name') }}" class="mt-1 w-full border rounded-xl p-3" required>
      @error('custom_company_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Judul KP</label>
      <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded-xl p-3" required>
      @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Unggah Berkas Persetujuan Instansi (PDF, maks 5MB)</label>
      <input type="file" name="approval" accept="application/pdf" class="mt-1" required>
      @error('approval') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Unggah Proposal (PDF, maks 5MB)</label>
      <input type="file" name="proposal" accept="application/pdf" class="mt-1" required>
      @error('proposal') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Unggah KRS (PDF/JPG/PNG, maks 5MB)</label>
      <input type="file" name="krs" accept="application/pdf,image/*" class="mt-1" required>
      @error('krs') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex gap-3">
      <button class="btn-primary" type="submit">Submit</button>
    </div>
  </form>
</div>
@endsection
