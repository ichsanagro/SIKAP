@extends('layouts.app')

@section('title', 'Detail Seminar KP')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Detail Seminar KP</h1>
                <a href="{{ route('supervisor.seminar.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <p class="text-sm text-gray-900">{{ $application->student->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIM</label>
                            <p class="text-sm text-gray-900">{{ $application->student->nim }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-sm text-gray-900">{{ $application->student->email }}</p>
                        </div>
                    </div>
                </div>

            <!-- Seminar Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Seminar</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                            <p class="text-sm text-gray-900">{{ $application->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->statusBadgeClass() }}">
                                {{ $application->statusText() }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dosen Penguji</label>
                            <p class="text-sm text-gray-900">{{ $application->examiner->name }}</p>
                        </div>
                        @if($application->seminar_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Seminar</label>
                            <p class="text-sm text-gray-900">{{ $application->seminar_date->format('d M Y') }}</p>
                        </div>
                        @endif
                        @if($application->seminar_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu Seminar</label>
                            <p class="text-sm text-gray-900">{{ $application->seminar_time->format('H:i') }}</p>
                        </div>
                        @endif
                        @if($application->seminar_location)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tempat Seminar</label>
                            <p class="text-sm text-gray-900">{{ $application->seminar_location }}</p>
                        </div>
                        @endif
                        @if($application->examiner_notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Dosen Penguji</label>
                            <p class="text-sm text-gray-900">{{ $application->examiner_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- KP Information -->
            @if($application->student->kpApplications->isNotEmpty())
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kerja Praktik</h3>
                @foreach($application->student->kpApplications as $kp)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-blue-700">Judul KP</label>
                            <p class="text-sm text-blue-900">{{ $kp->title ?? 'Tidak ada judul' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-700">Dosen Pembimbing</label>
                            <p class="text-sm text-blue-900">{{ $kp->supervisor->name ?? 'Belum ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-700">Perusahaan</label>
                            <p class="text-sm text-blue-900">{{ $kp->company->name ?? $kp->custom_company_name ?? 'Tidak ada perusahaan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-700">Status KP</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kp->statusBadgeClass() }}">
                                {{ $kp->verification_status ?? 'Pending' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Documents Section -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Seminar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Kegiatan Harian KP</h4>
                        <a href="{{ $application->kegiatan_harian_drive_link }}"
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Buka Link Drive
                        </a>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Bimbingan KP</h4>
                        <a href="{{ $application->bimbingan_kp_drive_link }}"
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Buka Link Drive
                        </a>
                    </div>
                </div>
            </div>

            @if($application->admin_note)
            <!-- Admin Note -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan Admin</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">{{ $application->admin_note }}</p>
                </div>
            </div>
            @endif

            <!-- Schedule Form -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Atur Jadwal Seminar</h3>
                <form action="{{ route('supervisor.seminar.update-schedule', $application) }}" method="POST" class="bg-green-50 border border-green-200 rounded-lg p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="seminar_date" class="block text-sm font-medium text-green-700 mb-2">Tanggal Seminar</label>
                            <input type="date"
                                   id="seminar_date"
                                   name="seminar_date"
                                   value="{{ old('seminar_date', $application->seminar_date?->format('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                            @error('seminar_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seminar_time" class="block text-sm font-medium text-green-700 mb-2">Waktu Seminar</label>
                            <input type="time"
                                   id="seminar_time"
                                   name="seminar_time"
                                   value="{{ old('seminar_time', $application->seminar_time?->format('H:i')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                            @error('seminar_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="seminar_location" class="block text-sm font-medium text-green-700 mb-2">Tempat Seminar</label>
                            <input type="text"
                                   id="seminar_location"
                                   name="seminar_location"
                                   value="{{ old('seminar_location', $application->seminar_location) }}"
                                   placeholder="Contoh: Ruang Seminar Lt. 3, Gedung A"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                            @error('seminar_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="examiner_notes" class="block text-sm font-medium text-green-700 mb-2">Catatan (Opsional)</label>
                            <textarea id="examiner_notes"
                                      name="examiner_notes"
                                      rows="3"
                                      placeholder="Catatan tambahan untuk mahasiswa..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('examiner_notes', $application->examiner_notes) }}</textarea>
                            @error('examiner_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
