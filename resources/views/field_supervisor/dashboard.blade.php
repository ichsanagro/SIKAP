@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Pengawas Lapangan</h1>
        <p class="text-gray-600 mt-2">Kelola mahasiswa KP, evaluasi, dan kuota instansi</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Data Mahasiswa KP -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Data Mahasiswa KP</h3>
                    <p class="text-sm text-gray-600">Lihat & kelola mahasiswa bimbingan</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('field.students.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Kelola Mahasiswa →
                </a>
            </div>
        </div>

        <!-- Memberikan Nilai -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Memberikan Nilai</h3>
                    <p class="text-sm text-gray-600">Nilai mahasiswa KP</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('field.scores.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    Kelola Nilai →
                </a>
            </div>
        </div>


    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['students'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Nilai -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Nilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['scores'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Aktivitas -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Aktivitas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['activities'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Scores -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Nilai Terbaru</h3>
            @if(isset($recentScores) && $recentScores->count() > 0)
                <div class="space-y-3">
                    @foreach($recentScores->take(5) as $score)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ optional($score->application->student)->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ optional($score->application->company)->name ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $score->final_score }}</p>
                                <p class="text-xs text-gray-500">Nilai Akhir</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('field.scores.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua Nilai →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada nilai yang diberikan</p>
            @endif
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Mahasiswa</h3>
            @if(isset($recentActivities) && $recentActivities->count() > 0)
                <div class="space-y-3">
                    @foreach($recentActivities->take(5) as $activity)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ optional($activity->kpApplication->student)->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity->date)->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($activity->status === 'APPROVED') bg-green-100 text-green-800
                                    @elseif($activity->status === 'REVISION') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($activity->status === 'PENDING')
                                      Menunggu
                                    @elseif($activity->status === 'APPROVED')
                                      Disetujui
                                    @elseif($activity->status === 'REVISION')
                                      Revisi
                                    @else
                                      {{ $activity->status }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('field.students.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                        Lihat Semua Aktivitas →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada aktivitas yang dicatat</p>
            @endif
        </div>
    </div>
</div>
@endsection
