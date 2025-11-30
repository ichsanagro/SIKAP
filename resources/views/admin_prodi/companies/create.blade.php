@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Instansi Baru</h1>
        <p class="text-gray-600 mt-2">Tambahkan data instansi untuk kerja praktik mahasiswa.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin-prodi.companies.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Instansi *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       oninvalid="this.setCustomValidity('Nama Instansi wajib diisi')" oninput="this.setCustomValidity('')"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="address" id="address" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact_person" class="block text-sm font-medium text-gray-700">Kontak Layanan</label>
                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('contact_person')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact_phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('contact_phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="mb-4">
                <label for="batch" class="block text-sm font-medium text-gray-700">Batch *</label>
                <select name="batch" id="batch" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Pilih Batch</option>
                    <option value="1" {{ old('batch') == '1' ? 'selected' : '' }}>Opsi 1</option>
                    <option value="2" {{ old('batch') == '2' ? 'selected' : '' }}>Opsi 2</option>
                </select>
                @error('batch')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="mb-6">
                <label for="quota" class="block text-sm font-medium text-gray-700">Kuota *</label>
                <input type="number" name="quota" id="quota" value="{{ old('quota', 0) }}" min="0" required
                       oninvalid="this.setCustomValidity('Kuota wajib diisi')" oninput="this.setCustomValidity('')"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('quota')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin-prodi.companies.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
