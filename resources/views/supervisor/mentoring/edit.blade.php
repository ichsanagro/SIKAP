@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Catatan Bimbingan</h1>
            <p class="text-gray-600 mt-2">{{ $mentoringLog->kpApplication->student->name }} - {{ \Carbon\Carbon::parse($mentoringLog->date)->format('d M Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('supervisor.mentoring.show', $mentoringLog) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat
            </a>
            <a href="{{ route('supervisor.mentoring.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('supervisor.mentoring.update', $mentoringLog) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Student (Read-only) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Mahasiswa
                </label>
                <div class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    <span class="text-sm text-gray-900">
                        {{ $mentoringLog->kpApplication->student->name }} - {{ $mentoringLog->kpApplication->student->nim }}
                    </span>
                </div>
            </div>

            <!-- KP Application (Read-only) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kerja Praktek
                </label>
                <div class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    <span class="text-sm text-gray-900">
                        {{ $mentoringLog->kpApplication->title }}
                    </span>
                </div>
            </div>

            <!-- Date -->
            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" id="date" value="{{ old('date', $mentoringLog->date->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required max="{{ date('Y-m-d') }}">
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Topic -->
            <div class="mb-6">
                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                    Topik Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="topic" id="topic" value="{{ old('topic', $mentoringLog->topic) }}"
                       placeholder="Masukkan topik bimbingan"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required maxlength="1000">
                @error('topic')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes for Student -->
            <div class="mb-6">
                <label for="student_notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan untuk Mahasiswa
                </label>
                <textarea name="student_notes" id="student_notes" rows="4"
                          placeholder="Berikan catatan atau feedback khusus untuk mahasiswa"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          maxlength="2000">{{ old('student_notes', $mentoringLog->student_notes) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter. Catatan ini akan dapat dilihat oleh mahasiswa.</p>
                @error('student_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Internal Notes (Read-only) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Internal Mahasiswa
                </label>
                <div class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    <span class="text-sm text-gray-900">{{ $mentoringLog->notes ?: 'Tidak ada catatan internal' }}</span>
                </div>
                <p class="mt-1 text-sm text-gray-500">Catatan internal mahasiswa tidak dapat diubah oleh dosen pembimbing.</p>
            </div>

            <!-- Status -->
            <div class="mb-6">
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



            <!-- Current Attachment -->
            @if($mentoringLog->attachment_path)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran Saat Ini
                    </label>
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-900">{{ basename($mentoringLog->attachment_path) }}</span>
                        </div>
                        @if(str_starts_with($mentoringLog->attachment_path, 'http'))
                            <a href="{{ $mentoringLog->attachment_path }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                        @else
                            <a href="{{ asset('storage/' . $mentoringLog->attachment_path) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload file baru untuk mengganti lampiran saat ini</p>
                </div>
            @endif

            <!-- Attachment -->
            <div class="mb-6">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $mentoringLog->attachment_path ? 'Ganti Lampiran (Link Google Drive, Opsional)' : 'Lampiran (Link Google Drive, Opsional)' }}
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
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('supervisor.mentoring.show', $mentoringLog) }}" class="btn-secondary">Batal</a>
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
@endsection
