{{-- resources/views/student/kp/edit.blade.php --}}
@extends('layouts.app')

@section('content')
  {{-- Tab navigasi mahasiswa (opsional) --}}

  <div class="card">
    <h2 class="text-2xl font-bold text-unibBlue mb-4">Ubah Draft Kerja Praktik</h2>

    {{-- FORM UPDATE (PUT) --}}
    <form method="POST"
          action="{{ route('kp-applications.update', $kp_application) }}"
          enctype="multipart/form-data"
          class="space-y-5">
      @csrf
      @method('PUT')

      {{-- Judul KP --}}
      <div>
        <label class="block font-semibold">Judul KP</label>
        <input
          type="text"
          name="title"
          value="{{ old('title', $kp_application->title) }}"
          class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
          required>
        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Pilihan Tempat (1/2 dari Prodi, 3 Mandiri) --}}
      <div>
        <label class="block font-semibold">Pilihan Tempat</label>
        @php $opt = old('placement_option', $kp_application->placement_option); @endphp
        <select
          name="placement_option"
          id="placement_option"
          class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue"
          required>
          <option value="1" @selected($opt==='1')>Opsi 1 (Prodi - Batch 1)</option>
          <option value="2" @selected($opt==='2')>Opsi 2 (Prodi - Batch 2)</option>
          <option value="3" @selected($opt==='3')>Opsi 3 (Cari Sendiri)</option>
        </select>
      </div>

      {{-- Perusahaan dari Prodi (untuk Opsi 1 & 2) --}}
      <div id="prodiBox" class="space-y-2">
        <label class="block font-semibold">Pilih Perusahaan dari Prodi</label>
        <select
          name="company_id"
          class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue">
          <optgroup label="Batch 1">
            @foreach($companiesBatch1 as $c)
              <option value="{{ $c->id }}"
                @selected(old('company_id', $kp_application->company_id) == $c->id)>
                {{ $c->name }} (kuota {{ $c->quota }})
              </option>
            @endforeach
          </optgroup>
          <optgroup label="Batch 2">
            @foreach($companiesBatch2 as $c)
              <option value="{{ $c->id }}"
                @selected(old('company_id', $kp_application->company_id) == $c->id)>
                {{ $c->name }} (kuota {{ $c->quota }})
              </option>
            @endforeach
          </optgroup>
        </select>
        @error('company_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      {{-- Perusahaan Mandiri (untuk Opsi 3) --}}
      <div id="customBox" class="space-y-3 hidden">
        <div>
          <label class="block font-semibold">Nama Perusahaan (Mandiri)</label>
          <input
            type="text"
            name="custom_company_name"
            value="{{ old('custom_company_name', $kp_application->custom_company_name) }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue">
        </div>
        <div>
          <label class="block font-semibold">Alamat Perusahaan</label>
          <input
            type="text"
            name="custom_company_address"
            value="{{ old('custom_company_address', $kp_application->custom_company_address) }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue">
        </div>
        <div>
          <label class="block font-semibold">Tanggal Mulai KP</label>
          <input
            type="date"
            name="start_date"
            value="{{ old('start_date', optional($kp_application->start_date)->format('Y-m-d')) }}"
            class="mt-1 w-full rounded-xl border p-3 focus:outline-none focus:ring-2 focus:ring-unibBlue focus:border-unibBlue">
          @error('start_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- KRS (boleh upload baru untuk mengganti) --}}
      <div>
        <label class="block font-semibold">Unggah/Perbarui KRS (PDF/JPG/PNG, maks 5MB)</label>
        <input
          type="file"
          name="krs"
          accept="application/pdf,image/*"
          class="mt-1">
        @error('krs') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

        @if($kp_application->krs_path)
          <p class="text-sm text-gray-600 mt-2">
            KRS saat ini:
            <a class="text-unibBlue underline" href="{{ route('kp.krs.download', $kp_application) }}">Lihat/Unduh</a>
            <span class="text-xs text-gray-500">(unggah file baru untuk mengganti)</span>
          </p>
        @endif

        <p class="text-xs text-gray-500 mt-1">KRS wajib ada sebelum melakukan <em>Submit</em>.</p>
      </div>

      {{-- Aksi --}}
      <div class="pt-2 flex flex-wrap gap-3">
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
        <a href="{{ route('kp-applications.show', $kp_application) }}" class="px-4 py-2 rounded-xl border">
          Batal
        </a>
      </div>
    </form>
  </div>

  {{-- Toggle tampilan box Prodi vs Mandiri --}}
  <script>
    const sel = document.getElementById('placement_option');
    const prodiBox = document.getElementById('prodiBox');
    const customBox = document.getElementById('customBox');

    function toggleBoxes() {
      if (!sel) return;
      if (sel.value === '3') {
        prodiBox?.classList.add('hidden');
        customBox?.classList.remove('hidden');
      } else {
        prodiBox?.classList.remove('hidden');
        customBox?.classList.add('hidden');
      }
    }

    sel?.addEventListener('change', toggleBoxes);
    // set keadaan awal sesuai nilai saat ini
    toggleBoxes();
  </script>
@endsection
