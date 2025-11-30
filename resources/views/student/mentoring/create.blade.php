@extends('layouts.app')
@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Tambah Catatan Bimbingan</h2>

  @if($myKps->isEmpty())
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
      <p>Anda tidak dapat Bimbingan saat ini. Mohon pastikan judul KP telah disetujui oleh Dosen Pembimbing.</p>
    </div>
  @else
  <form method="POST" action="{{ route('mentoring-logs.store') }}" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf
      <div>
        <label class="block font-semibold">Pilih KP</label>
        <select name="kp_application_id" class="mt-1 w-full border rounded-xl p-3">
          @foreach($myKps as $k)
            <option value="{{ $k->id }}">{{ $k->title }}</option>
          @endforeach
        </select>
        @error('kp_application_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
      <div>
        <label class="block font-semibold">Tanggal</label>
        <input type="date" name="date" class="mt-1 w-full border rounded-xl p-3">
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
        <label class="block font-semibold">Lampiran (Link Google Drive, opsional)</label>
        <input type="url" name="attachment" id="attachment" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3">
        <p id="attachment-error" class="text-red-600 text-sm hidden">Link tidak valid</p>
      </div>
      <div class="pt-2">
        <button class="btn-primary">Simpan</button>
      </div>
    </form>

    <script>
      // Custom validation messages in Indonesian
      const inputs = document.querySelectorAll('select[name="kp_application_id"], input[name="date"], input[name="topic"]');
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

      // Validate Google Drive link
      const attachmentInput = document.getElementById('attachment');
      const attachmentError = document.getElementById('attachment-error');
      attachmentInput.addEventListener('input', function() {
        const value = this.value;
        if (value && !/^https:\/\/(drive|docs)\.google\.com\//.test(value)) {
          attachmentError.classList.remove('hidden');
          this.setCustomValidity('Link tidak valid');
        } else {
          attachmentError.classList.add('hidden');
          this.setCustomValidity('');
        }
      });
    </script>
  @endif
</div>
@endsection
