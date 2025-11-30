@extends('layouts.app')

@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Form Pendaftaran KP - {{ $company->name }}</h2>

  <form method="POST" action="{{ route('kp.apply.store', $company) }}" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf

    <div>
      <label class="block font-semibold">Judul KP</label>
      <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded-xl p-3">
      @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link Drive KRS</label>
      <input type="url" name="krs_drive_link" value="{{ old('krs_drive_link') }}" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3">
      @error('krs_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Link Drive Proposal</label>
      <input type="url" name="proposal_drive_link" value="{{ old('proposal_drive_link') }}" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3">
      @error('proposal_drive_link') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex gap-3">
      <button class="btn-primary" type="submit">Kirim</button>
    </div>
  </form>

  <script>
    // Custom validation messages in Indonesian
    const inputs = document.querySelectorAll('input[name="title"], input[name="krs_drive_link"], input[name="proposal_drive_link"]');
    inputs.forEach(input => {
      input.addEventListener('invalid', function(event) {
        if (input.validity.valueMissing) {
          input.setCustomValidity('Kolom ini wajib diisi.');
        } else if (input.type === 'url' && input.validity.typeMismatch) {
          input.setCustomValidity('Masukkan URL yang valid (misalnya https://drive.google.com/...).');
        } else if (input.name.includes('drive_link') && !/^https:\/\/drive\.google\.com\/.+$/.test(input.value)) {
          input.setCustomValidity('Link tidak valid');
        } else {
          input.setCustomValidity('');
        }
      });
      input.addEventListener('input', function() {
        input.setCustomValidity('');
      });
    });
  </script>
</div>
@endsection
