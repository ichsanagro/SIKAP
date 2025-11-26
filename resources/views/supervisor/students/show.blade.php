@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Mahasiswa</h1>
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

    <!-- Student and KP Details Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h2>        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">NIM</label>
                <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->nim ?? '-' }}</p>
            </div>
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
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Total Log Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Bimbingan</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $kpApplication->mentoringLogs->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Approved Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $kpApplication->mentoringLogs->where('status', 'APPROVED')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $kpApplication->mentoringLogs->whereIn('status', ['PENDING', 'REVISION'])->count() }}</dd>
                    </dl>
                </div>
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
