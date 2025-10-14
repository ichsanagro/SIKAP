@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Kuota Instansi</h1>
            <p class="text-gray-600 mt-2">Tentukan kuota mahasiswa untuk periode tertentu</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('field.company-quotas.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('field.company-quotas.store') }}">
            @csrf

            <!-- Company Selection -->
            <div class="mb-6">
                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Instansi <span class="text-red-500">*</span>
                </label>
                <select name="company_id" id="company_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                                data-address="{{ $company->address ?? '-' }}">
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Info Display -->
            <div id="company_info" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Informasi Instansi</h3>
                <div class="text-sm">
                    <span class="font-medium">Alamat:</span>
                    <span id="company_address" class="text-gray-700 ml-2">-</span>
                </div>
            </div>

            <!-- Period -->
            <div class="mb-6">
                <label for="period" class="block text-sm font-medium text-gray-700 mb-2">
                    Periode <span class="text-red-500">*</span>
                </label>
                <select name="period" id="period"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <option value="">-- Pilih Periode --</option>
                    @php
                        $currentYear = date('Y');
                        $nextYear = $currentYear + 1;
                    @endphp
                    <option value="{{ $currentYear }}/Genap">Semester Genap {{ $currentYear }}</option>
                    <option value="{{ $nextYear }}/Ganjil">Semester Ganjil {{ $nextYear }}</option>
                    <option value="{{ $nextYear }}/Genap">Semester Genap {{ $nextYear }}</option>
                    <option value="{{ $nextYear + 1 }}/Ganjil">Semester Ganjil {{ $nextYear + 1 }}</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">Pilih periode akademik untuk kuota ini</p>
                @error('period')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quota -->
            <div class="mb-6">
                <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">
                    Kuota Mahasiswa <span class="text-red-500">*</span>
                </label>
                <input type="number" name="quota" id="quota" value="{{ old('quota') }}"
                       min="1" max="10000"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Masukkan jumlah kuota mahasiswa"
                       required>
                <p class="mt-1 text-sm text-gray-500">Maksimal 10.000 mahasiswa per periode</p>
                @error('quota')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('field.company-quotas.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Kuota
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const companySelect = document.getElementById('company_id');
    const companyInfo = document.getElementById('company_info');
    const companyAddress = document.getElementById('company_address');

    // Handle company selection
    companySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            companyAddress.textContent = selectedOption.getAttribute('data-address') || '-';
            companyInfo.classList.remove('hidden');
        } else {
            companyInfo.classList.add('hidden');
        }
    });
});
</script>
@endsection
