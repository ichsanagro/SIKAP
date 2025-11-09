@extends('layouts.app')

@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Form Pendaftaran KP - {{ $company->name }}</h2>

  <form method="POST" action="{{ route('kp.apply.store', $company) }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label class="block font-semibold">Judul KP</label>
      <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded-xl p-3" required>
      @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link Drive KRS</label>
      <input type="url" name="krs_drive_link" value="{{ old('krs_drive_link') }}" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3" required>
      @error('krs_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link Drive Proposal</label>
      <input type="url" name="proposal_drive_link" value="{{ old('proposal_drive_link') }}" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3" required>
      @error('proposal_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex gap-3">
      <button class="btn-primary" type="submit">Submit</button>
    </div>
  </form>
</div>
@endsection
