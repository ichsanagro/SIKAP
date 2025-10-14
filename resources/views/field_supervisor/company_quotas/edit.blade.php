@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Kuota Instansi</h1>
            <p class="text-gray-600 mt-2">Perbarui kuota mahasiswa untuk periode tertentu</p>
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
        <form method="POST" action="{{ route('field.company-quotas.update', $quota) }}">
            @csrf
            @method('PUT')

            <!-- Company Info Display -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Informasi Instansi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium">Nama:</span>
                        <span class="text-gray-700 ml-2">{{ $quota->company->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Alamat:</span>
                        <span class="text-gray-700 ml-2">{{ $quota->company->address ?? '-' }}</span>
                    </div>
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
                    <option value="{{ $currentYear }}/Genap" {{ $quota->period == $currentYear.'/Genap' ? 'selected' : '' }}>Semester Genap {{ $currentYear }}</option>
                    <option value="{{ $nextYear }}/Ganjil" {{ $quota->period == $nextYear.'/Ganjil' ? 'selected' : '' }}>Semester Ganjil {{ $nextYear }}</option>
                    <option value="{{ $nextYear }}/Genap" {{ $quota->period == $nextYear.'/Genap' ? 'selected' : '' }}>Semester Genap {{ $nextYear }}</option>
                    <option value="{{ $nextYear + 1 }}/Ganjil" {{ $quota->period == ($nextYear + 1).'/Ganjil' ? 'selected' : '' }}>Semester Ganjil {{ $nextYear + 1 }}</option>
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
                <input type="number" name="quota" id="quota" value="{{ old('quota', $quota->quota) }}"
                       min="1" max="10000"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Masukkan jumlah kuota mahasiswa"
                       required>
                <p class="mt-1 text-sm text-gray-500">Maksimal 10.000 mahasiswa per periode</p>
                @error('quota')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Usage Info -->
            @php
                $used = $quota->company->applications()
                    ->where('period', $quota->period)
                    ->whereIn('status', ['APPROVED', 'ONGOING', 'COMPLETED'])
                    ->count();
                $remaining = max(0, $quota->quota - $used);
            @endphp
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-blue-900 mb-2">Status Penggunaan Kuota</h3>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-blue-800">Total Kuota:</span>
                        <span class="text-blue-700 ml-2">{{ $quota->quota }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-blue-800">Terpakai:</span>
                        <span class="text-blue-700 ml-2">{{ $used }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-blue-800">Sisa:</span>
                        <span class="text-blue-700 ml-2">{{ $remaining }}</span>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('field.company-quotas.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Kuota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
