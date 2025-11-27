@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Pengawas Lapangan</h1>
        <p class="text-gray-600 mt-2">Kelola mahasiswa KP, evaluasi, dan kuota instansi</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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

        <!-- Evaluasi & Feedback -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Evaluasi & Feedback</h3>
                    <p class="text-sm text-gray-600">Kuesioner evaluasi kinerja</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('field.evaluations.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Kelola Evaluasi →
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

        <!-- Total Evaluasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Evaluasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['evaluations'] ?? 0 }}</p>
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
                                <p class="text-xs text-gray-500">Final Score</p>
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

        <!-- Recent Evaluations -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Evaluasi Terbaru</h3>
            @if(isset($recentEvaluations) && $recentEvaluations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentEvaluations->take(5) as $evaluation)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ optional($evaluation->application->student)->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ optional($evaluation->application->company)->name ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $evaluation->overall_score ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">Overall Score</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('field.evaluations.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                        Lihat Semua Evaluasi →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada evaluasi yang dibuat</p>
            @endif
        </div>
    </div>
</div>
@endsection
