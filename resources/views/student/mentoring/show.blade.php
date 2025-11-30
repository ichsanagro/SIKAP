@extends('layouts.app')
@section('content')

<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-unibBlue">Detail Catatan Bimbingan</h1>
            <p class="text-gray-600 mt-2">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('mentoring-logs.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        @if($log->status === 'APPROVED')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                ✓ Disetujui
            </span>
        @elseif($log->status === 'PENDING')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                ⏳ Menunggu Persetujuan
            </span>
        @elseif($log->status === 'REVISION')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                ⚠ Perlu Revisi
            </span>
        @else
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                {{ $log->status }}
            </span>
        @endif
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Mentoring Details -->
            <div class="card">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Bimbingan</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($log->date)->format('l, d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Topik</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $log->topic }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan Anda</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-lg p-4">
                            {{ $log->notes ?: 'Tidak ada catatan' }}
                        </div>
                    </div>
                    @if($log->student_notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Feedback Dosen Pembimbing</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                            {{ $log->student_notes }}
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- KP Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kerja Praktik</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Judul</label>
                        <p class="text-sm text-gray-900">{{ $log->kpApplication->title }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Instansi</label>
                        <p class="text-sm text-gray-900">{{ $log->kpApplication->company->name ?? 'Belum ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Dosen Pembimbing</label>
                        <p class="text-sm text-gray-900">{{ $log->supervisor->name ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>
            </div>

            <!-- Attachment -->
            @if($log->attachment_path)
                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Lampiran</h2>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Lampiran Bimbingan</p>
                                <p class="text-sm text-gray-500">{{ basename($log->attachment_path) }}</p>
                            </div>
                        </div>
                        @if(str_starts_with($log->attachment_path, 'http'))
                            <a href="{{ $log->attachment_path }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat File →
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $log->attachment_path) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat File →
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
