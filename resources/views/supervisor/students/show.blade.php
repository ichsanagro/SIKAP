@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Mahasiswa</h1>
            <p class="text-gray-600 mt-2">{{ $kpApplication->student->name }} - {{ $kpApplication->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('supervisor.students.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">NIM</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->nim ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- KP Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Kerja Praktek</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Judul KP</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->title }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Instansi</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->company->name ?? 'Belum ditentukan' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Instansi</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->company->address ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->start_date ? \Carbon\Carbon::parse($kpApplication->start_date)->format('d M Y') : '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->end_date ? \Carbon\Carbon::parse($kpApplication->end_date)->format('d M Y') : '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
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
                    $status = $statusConfig[$kpApplication->status] ?? ['label' => $kpApplication->status, 'color' => 'gray'];
                @endphp
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                    {{ $status['label'] }}
                </span>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Mentoring Logs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan Bimbingan</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Log</span>
                    <span class="text-sm font-medium text-gray-900">{{ $kpApplication->mentoringLogs->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Disetujui</span>
                    <span class="text-sm font-medium text-green-600">{{ $kpApplication->mentoringLogs->where('status', 'APPROVED')->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Menunggu</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $kpApplication->mentoringLogs->whereIn('status', ['PENDING', 'REVISION'])->count() }}</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('supervisor.mentoring.index') }}?student={{ $kpApplication->student_id }}"
                   class="text-sm text-blue-600 hover:text-blue-800">Lihat semua log →</a>
            </div>
        </div>

        <!-- Scores -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Penilaian</h3>
            @if($kpApplication->scores->isNotEmpty())
                @php $score = $kpApplication->scores->first(); @endphp
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Nilai</span>
                        <span class="text-sm font-medium text-gray-900">{{ $score->score }}/100</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Grade</span>
                        <span class="text-sm font-medium text-gray-900">{{ $score->grade }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('supervisor.scores.edit', $score) }}"
                       class="text-sm text-blue-600 hover:text-blue-800">Edit nilai →</a>
                </div>
            @else
                <p class="text-sm text-gray-500">Belum ada penilaian</p>
                @if($kpApplication->status === 'COMPLETED')
                    <div class="mt-4">
                        <a href="{{ route('supervisor.scores.create') }}?student={{ $kpApplication->id }}"
                           class="text-sm text-blue-600 hover:text-blue-800">Berikan nilai →</a>
                    </div>
                @endif
            @endif
        </div>

        <!-- Documents -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Laporan</span>
                    @if($kpApplication->reports->isNotEmpty())
                        <span class="text-sm font-medium text-green-600">Ada</span>
                    @else
                        <span class="text-sm font-medium text-gray-500">Belum</span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Kuesioner</span>
                    @if($kpApplication->questionnaires->isNotEmpty())
                        <span class="text-sm font-medium text-green-600">Ada</span>
                    @else
                        <span class="text-sm font-medium text-gray-500">Belum</span>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('supervisor.documents.show', $kpApplication) }}"
                   class="text-sm text-blue-600 hover:text-blue-800">Lihat dokumen →</a>
            </div>
        </div>
    </div>

    <!-- Recent Mentoring Logs -->
    @if($kpApplication->mentoringLogs->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Catatan Bimbingan Terbaru</h2>
            <div class="space-y-4">
                @foreach($kpApplication->mentoringLogs->take(5) as $log)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-gray-900">{{ $log->topic }}</h4>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($log->notes, 100) }}</p>
                        @if($log->status === 'PENDING')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-2">
                                Menunggu Persetujuan
                            </span>
                        @elseif($log->status === 'APPROVED')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-2">
                                Disetujui
                            </span>
                        @elseif($log->status === 'REVISION')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 mt-2">
                                Perlu Revisi
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{ route('supervisor.mentoring.index') }}?student={{ $kpApplication->student_id }}"
                   class="text-sm text-blue-600 hover:text-blue-800">Lihat semua catatan →</a>
            </div>
        </div>
    @endif
</div>
@endsection
