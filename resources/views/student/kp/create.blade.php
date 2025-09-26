@extends('layouts.app')

@section('content')
@include('student.partials.nav')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Ajukan Kerja Praktek</h2>

  <form method="POST" action="{{ route('kp-applications.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label class="block font-semibold">Judul KP</label>
      <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded-xl p-3" required>
      @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-semibold">Pilihan Tempat</label>
      <select name="placement_option" id="placement_option" class="mt-1 w-full border rounded-xl p-3" required>
        <option value="1" @selected(old('placement_option')==='1')>Opsi 1 (Prodi - Batch 1)</option>
        <option value="2" @selected(old('placement_option')==='2')>Opsi 2 (Prodi - Batch 2)</option>
        <option value="3" @selected(old('placement_option')==='3')>Opsi 3 (Cari Sendiri)</option>
      </select>
    </div>

    <div id="prodiBox" class="space-y-2">
      <label class="block font-semibold">Pilih Perusahaan dari Prodi</label>
      <select name="company_id" class="mt-1 w-full border rounded-xl p-3">
        <optgroup label="Batch 1">
          @foreach($companiesBatch1 as $c)
            <option value="{{ $c->id }}" @selected(old('company_id')==$c->id)>{{ $c->name }} (kuota {{ $c->quota }})</option>
          @endforeach
        </optgroup>
        <optgroup label="Batch 2">
          @foreach($companiesBatch2 as $c)
            <option value="{{ $c->id }}" @selected(old('company_id')==$c->id)>{{ $c->name }} (kuota {{ $c->quota }})</option>
          @endforeach
        </optgroup>
      </select>
      @error('company_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div id="customBox" class="space-y-2 hidden">
      <label class="block font-semibold">Nama Perusahaan (Opsi 3)</label>
      <input name="custom_company_name" value="{{ old('custom_company_name') }}" class="mt-1 w-full border rounded-xl p-3">
      <label class="block font-semibold">Alamat Perusahaan</label>
      <input name="custom_company_address" value="{{ old('custom_company_address') }}" class="mt-1 w-full border rounded-xl p-3">
      <label class="block font-semibold">Tanggal Mulai KP</label>
      <input type="date" name="start_date" value="{{ old('start_date') }}" class="mt-1 w-full border rounded-xl p-3">
      @error('start_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- KRS wajib sebelum submit (boleh unggah saat draft) --}}
    <div>
      <label class="block font-semibold">Unggah KRS (PDF/JPG/PNG, maks 5MB)</label>
      <input type="file" name="krs" accept="application/pdf,image/*" class="mt-1">
      @error('krs') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      <p class="text-xs text-gray-500 mt-1">KRS wajib ada sebelum menekan tombol Submit (bisa diunggah saat draft).</p>
    </div>

    <div class="pt-2 flex gap-3">
      <button class="btn-primary" type="submit">Simpan Draft</button>
    </div>
  </form>
</div>

<script>
  const sel = document.getElementById('placement_option');
  const prodiBox = document.getElementById('prodiBox');
  const customBox = document.getElementById('customBox');
  function toggleBoxes() {
    if (sel.value === '3') { prodiBox.classList.add('hidden'); customBox.classList.remove('hidden'); }
    else { prodiBox.classList.remove('hidden'); customBox.classList.add('hidden'); }
  }
  sel.addEventListener('change', toggleBoxes);
  toggleBoxes();
</script>
@endsection
