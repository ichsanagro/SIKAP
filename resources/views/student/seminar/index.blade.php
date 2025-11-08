@extends('layouts.app')

@section('title', 'Seminar KP')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Pengajuan Seminar KP</h1>
                @if($applications->isEmpty())
                    <button onclick="document.getElementById('seminar-form').classList.remove('hidden')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Ajukan Seminar
                    </button>
                @endif
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($applications->isNotEmpty())
                <div class="space-y-4">
                    @foreach($applications as $application)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-lg">Pengajuan Seminar KP</h3>
                                    <p class="text-sm text-gray-600">Dibuat: {{ $application->created_at->format('d M Y') }}</p>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->statusBadgeClass() }}">
                                            {{ $application->statusText() }}
                                        </span>
                                    </div>
                                    @if($application->status === 'APPROVED' && ($application->seminar_date || $application->seminar_time || $application->seminar_location))
                                        <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                            <h4 class="text-sm font-semibold text-green-800 mb-2">Jadwal Seminar</h4>
                                            <div class="space-y-1 text-sm text-green-700">
                                                @if($application->seminar_date)
                                                    <p><strong>Tanggal:</strong> {{ $application->seminar_date->format('d M Y') }}</p>
                                                @endif
                                                @if($application->seminar_time)
                                                    <p><strong>Waktu:</strong> {{ $application->seminar_time->format('H:i') }}</p>
                                                @endif
                                                @if($application->seminar_location)
                                                    <p><strong>Tempat:</strong> {{ $application->seminar_location }}</p>
                                                @endif
                                                @if($application->examiner_notes)
                                                    <div class="mt-2 pt-2 border-t border-green-300">
                                                        <p><strong>Catatan:</strong> {{ $application->examiner_notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($application->status === 'REJECTED' && $application->admin_note)
                                        <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded">
                                            <p class="text-sm text-red-700">
                                                <strong>Catatan Admin:</strong> {{ $application->admin_note }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <a href="{{ Storage::url($application->kegiatan_harian_path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 text-sm underline">
                                        Lihat Kegiatan Harian
                                    </a>
                                    <br>
                                    <a href="{{ Storage::url($application->bimbingan_kp_path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 text-sm underline">
                                        Lihat Bimbingan KP
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Seminar Application Form -->
                <div id="seminar-form" class="hidden">
                    <form action="{{ route('seminar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="kegiatan_harian_kp" class="block text-sm font-medium text-gray-700 mb-2">
                                File Kegiatan Harian KP <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                   id="kegiatan_harian_kp"
                                   name="kegiatan_harian_kp"
                                   accept=".pdf"
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">Format: PDF, Maksimal 10MB</p>
                        </div>

                        <div>
                            <label for="bimbingan_kp" class="block text-sm font-medium text-gray-700 mb-2">
                                File Bimbingan KP <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                   id="bimbingan_kp"
                                   name="bimbingan_kp"
                                   accept=".pdf"
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">Format: PDF, Maksimal 10MB</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                    onclick="document.getElementById('seminar-form').classList.add('hidden')"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                                Batal
                            </button>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Ajukan Seminar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-graduation-cap text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengajuan Seminar</h3>
                    <p class="text-gray-500 mb-4">Ajukan seminar KP Anda untuk melengkapi proses kerja praktik.</p>
                    <button onclick="document.getElementById('seminar-form').classList.remove('hidden')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Ajukan Seminar Sekarang
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
