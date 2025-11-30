@extends('layouts.app')

@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Form Pengajuan Instansi Lain</h2>

  <form method="POST" action="{{ route('kp.apply.other.store') }}" class="space-y-4">
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
      <label class="block font-semibold">Link Berkas Persetujuan Instansi</label>
      <input type="url" name="approval_drive_link" value="{{ old('approval_drive_link') }}" class="mt-1 w-full border rounded-xl p-3" placeholder="https://drive.google.com/..." required>
      @error('approval_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link Proposal</label>
      <input type="url" name="proposal_drive_link" value="{{ old('proposal_drive_link') }}" class="mt-1 w-full border rounded-xl p-3" placeholder="https://drive.google.com/..." required>
      @error('proposal_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link KRS</label>
      <input type="url" name="krs_drive_link" value="{{ old('krs_drive_link') }}" class="mt-1 w-full border rounded-xl p-3" placeholder="https://drive.google.com/..." required>
      @error('krs_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex gap-3">
      <button class="btn-primary" type="submit">Kirim</button>
    </div>
  </form>
</div>
@endsection
