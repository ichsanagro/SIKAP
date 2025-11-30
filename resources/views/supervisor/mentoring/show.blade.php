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
                Ubah
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
                        @if(str_starts_with($mentoringLog->attachment_path, 'http'))
                            <a href="{{ $mentoringLog->attachment_path }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat File →
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $mentoringLog->attachment_path) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat File →
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <form method="POST" action="{{ route('supervisor.mentoring.update', $mentoringLog) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Catatan untuk Mahasiswa -->
                    <div class="mb-4">
                        <label for="student_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan untuk Mahasiswa
                        </label>
                        <textarea name="student_notes" id="student_notes" rows="3"
                                  placeholder="Berikan catatan atau feedback khusus untuk mahasiswa"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  maxlength="2000">{{ old('student_notes', $mentoringLog->student_notes) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter. Catatan ini akan dapat dilihat oleh mahasiswa.</p>
                        @error('student_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Bimbingan -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Bimbingan <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="PENDING" {{ old('status', $mentoringLog->status) === 'PENDING' ? 'selected' : '' }}>
                                Menunggu Persetujuan
                            </option>
                            <option value="APPROVED" {{ old('status', $mentoringLog->status) === 'APPROVED' ? 'selected' : '' }}>
                                Disetujui
                            </option>
                            <option value="REVISION" {{ old('status', $mentoringLog->status) === 'REVISION' ? 'selected' : '' }}>
                                Perlu Revisi
                            </option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Pilih status bimbingan saat ini</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lampiran (Opsional) -->
                    <div class="mb-4">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                            Lampiran (Link Google Drive, Opsional)
                        </label>
                        <input type="url" name="attachment" id="attachment" value="{{ old('attachment') }}"
                               placeholder="https://drive.google.com/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Masukkan link Google Drive untuk lampiran</p>
                        @error('attachment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        {{-- <a href="{{ route('supervisor.mentoring.edit', $mentoringLog) }}" class="btn-secondary">Ubah Lengkap</a> --}}
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
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
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kerja Praktik</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Judul</label>
                        <p class="text-sm text-gray-900">{{ $mentoringLog->kpApplication->title }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Instansi</label>
                        <p class="text-sm text-gray-900">{{ $mentoringLog->kpApplication->company->name ?? $mentoringLog->kpApplication->custom_company_name ?? 'Belum ditentukan' }}</p>
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
        </div>
    </div>
</div>
@endsection
