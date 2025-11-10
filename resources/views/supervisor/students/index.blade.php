@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mahasiswa Bimbingan</h1>
            <p class="text-gray-600 mt-2">Daftar mahasiswa yang Anda bimbing</p>
        </div>
        <a href="{{ route('supervisor.dashboard') }}" class="btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $students->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $students->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bimbingan Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $students->sum(function($student) { return $student->kpApplications->sum(function($kp) { return $kp->mentoringLogs->whereIn('status', ['PENDING', 'REVISION'])->count(); }); }) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">KP Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $students->sum(function($student) { return $student->kpApplications->where('status', 'COMPLETED')->count(); }) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Mahasiswa</h2>
        </div>

        @if($hasStudents && $students->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($students as $student)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-lg font-medium text-blue-600">{{ substr($student->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $student->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                                    @if($student->nim)
                                        <p class="text-sm text-gray-500">NIM: {{ $student->nim }} - {{ $student->prodi ?? 'Prodi belum ditentukan' }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $student->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>

                        <!-- KP Applications -->
                        @if($student->kpApplications->count() > 0)
                            <div class="mt-4 space-y-3">
                                @foreach($student->kpApplications as $kp)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $kp->title }}</h4>
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
                                                $status = $statusConfig[$kp->status] ?? ['label' => $kp->status, 'color' => 'gray'];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                                {{ $status['label'] }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                            <div>
                                                <span class="font-medium">Instansi:</span> {{ $kp->company->name ?? 'Belum ditentukan' }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Tanggal Mulai:</span> {{ $kp->start_date ? \Carbon\Carbon::parse($kp->start_date)->format('d M Y') : '-' }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Log Bimbingan:</span> {{ $kp->mentoringLogs->count() }}
                                            </div>
                                        </div>
                                        @if($kp->mentoringLogs->count() > 0)
                                            <div class="mt-3">
                                                <p class="text-xs text-gray-500 mb-2">Log bimbingan terbaru:</p>
                                                <div class="space-y-1">
                                                    @foreach($kp->mentoringLogs->take(2) as $log)
                                                        <div class="text-xs bg-white p-2 rounded">
                                                            <span class="font-medium">{{ $log->topic }}</span>
                                                            <span class="text-gray-500"> - {{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</span>
                                                            @if($log->status === 'PENDING')
                                                                <span class="ml-2 inline-flex px-1 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @elseif($log->status === 'APPROVED')
                                                                <span class="ml-2 inline-flex px-1 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif($log->status === 'REVISION')
                                                                <span class="ml-2 inline-flex px-1 py-0.5 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Revisi</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    @if($kp->mentoringLogs->count() > 2)
                                                        <p class="text-xs text-blue-600">+{{ $kp->mentoringLogs->count() - 2 }} lainnya</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-4 text-sm text-gray-500">
                                Belum ada pengajuan KP
                            </div>
                        @endif

                        <!-- Action Button -->
                        <div class="mt-4 flex justify-end">
                            @if($student->kpApplications->count() > 0)
                                <a href="{{ route('supervisor.students.show', $student->kpApplications->first()) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Detail KP
                                </a>
                            @else
                                <span class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Belum Ada KP
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $students->links() }}
            </div>
        @else
            <!-- Empty State - No students assigned -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada mahasiswa yang ditugaskan</h3>
                <p class="mt-1 text-sm text-gray-500">Mahasiswa yang Anda bimbing akan muncul di sini setelah ditugaskan oleh Admin Prodi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
