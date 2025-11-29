@extends('layouts.app')
@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Tambah Catatan Bimbingan</h2>

  @if($myKps->isEmpty())
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
      <p>Anda belum dapat melakukan bimbingan. Pastikan:</p>
      <ul class="list-disc list-inside mt-2">
        <li>Judul KP Anda sudah di-approve oleh dosen pembimbing</li>
        <li>Dosen pembimbing sudah ditetapkan</li>
      </ul>
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
        <input type="url" name="attachment" placeholder="https://drive.google.com/..." class="mt-1 w-full border rounded-xl p-3">
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
    </script>
  @endif
</div>
@endsection
