@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Catatan Bimbingan</h1>
            <p class="text-gray-600 mt-2">{{ $mentoringLog->kpApplication->student->name }} - {{ \Carbon\Carbon::parse($mentoringLog->date)->format('d M Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('supervisor.mentoring.edit', $mentoringLog) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('supervisor.mentoring.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        @if($mentoringLog->status === 'APPROVED')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                ✓ Disetujui
            </span>
        @elseif($mentoringLog->status === 'PENDING')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                ⏳ Menunggu Persetujuan
            </span>
        @elseif($mentoringLog->status === 'REVISION')
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                ⚠ Perlu Revisi
            </span>
        @else
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                {{ $mentoringLog->status }}
            </span>
        @endif
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Mentoring Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Bimbingan</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($mentoringLog->date)->format('l, d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Topik</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $mentoringLog->topic }}</p>
                    </div>
                    @if($mentoringLog->student_notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan untuk Mahasiswa</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                            {{ $mentoringLog->student_notes }}
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan Internal</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-lg p-4">
                            {{ $mentoringLog->notes ?: 'Tidak ada catatan internal' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attachment -->
            @if($mentoringLog->attachment_path)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Lampiran</h2>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Lampiran Bimbingan</p>
                                <p class="text-sm text-gray-500">{{ basename($mentoringLog->attachment_path) }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $mentoringLog->attachment_path) }}"
                           target="_blank"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat File →
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Student Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Mahasiswa</h3>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-blue-600">{{ substr($mentoringLog->kpApplication->student->name, 0, 2) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $mentoringLog->kpApplication->student->name }}</p>
                        <p class="text-sm text-gray-500">{{ $mentoringLog->kpApplication->student->nim }}</p>
                    </div>
                </div>
                <a href="{{ route('supervisor.students.show', $mentoringLog->kpApplication) }}"
                   class="text-sm text-blue-600 hover:text-blue-800">Lihat detail mahasiswa →</a>
            </div>

            <!-- KP Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kerja Praktek</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Judul</label>
                        <p class="text-sm text-gray-900">{{ $mentoringLog->kpApplication->title }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Instansi</label>
                        <p class="text-sm text-gray-900">{{ $mentoringLog->kpApplication->company->name ?? 'Belum ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Status KP</label>
                        @php
                            $statusConfig = [
                                'DRAFT' => ['label' => 'Draft', 'color' => 'gray'],
                                'SUBMITTED' => ['label' => 'Diajukan', 'color' => 'blue'],
                                'VERIFIED_PRODI' => ['label' => 'Diverifikasi Prodi', 'color' => 'yellow'],
                                'ASSIGNED_SUPERVISOR' => ['label' => 'Dosen Pembimbing Ditugaskan', 'color' => 'purple'],
                                'APPROVED' => ['label' => 'Disetujui', 'color' => 'green'],
                                'COMPLETED' => ['label' => 'Selesai', 'color' => 'green'],
                                'REJECTED' => ['label' => 'Ditolak', 'color' => 'red'],
                            ];
                            $status = $statusConfig[$mentoringLog->kpApplication->status] ?? ['label' => $mentoringLog->kpApplication->status, 'color' => 'gray'];
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('supervisor.students.show', $mentoringLog->kpApplication) }}"
                   class="text-sm text-blue-600 hover:text-blue-800 block mt-3">Lihat detail KP →</a>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('supervisor.mentoring.edit', $mentoringLog) }}"
                       class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Catatan
                    </a>
                    <form method="POST" action="{{ route('supervisor.mentoring.destroy', $mentoringLog) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan bimbingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Catatan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
