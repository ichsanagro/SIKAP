@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Rekap Nilai</h1>
                    <p class="text-gray-600 mt-1">{{ $kpApplication->student->name }} - {{ $kpApplication->student->nim }}</p>
                </div>
                <a href="{{ route('admin-prodi.recap-scores.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Student Information -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Mahasiswa</h2>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">NIM</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->nim }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Perusahaan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $kpApplication->company->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Dosen pembimbing</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $kpApplication->supervisor->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Pengawas Lapangan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $kpApplication->fieldSupervisor->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($kpApplication->status === 'COMPLETED') bg-green-100 text-green-800
                            @elseif($kpApplication->status === 'APPROVED') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $kpApplication->status }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Scores Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Supervisor Score -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Nilai Dosen Pembimbing</h3>
            </div>
            <div class="p-6">
                @if($kpApplication->supervisorScore)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Laporan</span>
                            <span class="text-sm font-medium">{{ $kpApplication->supervisorScore->report }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Presentasi</span>
                            <span class="text-sm font-medium">{{ $kpApplication->supervisorScore->presentation }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Sikap</span>
                            <span class="text-sm font-medium">{{ $kpApplication->supervisorScore->attitude }}/100</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Rata-rata</span>
                                <span>{{ $kpApplication->supervisorScore->final_score }}/100</span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada nilai</p>
                @endif
            </div>
        </div>

        <!-- Field Supervisor Score -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Nilai Pengawas Lapangan</h3>
            </div>
            <div class="p-6">
                @if($kpApplication->score)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Disiplin</span>
                            <span class="text-sm font-medium">{{ $kpApplication->score->discipline }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Keterampilan</span>
                            <span class="text-sm font-medium">{{ $kpApplication->score->skill }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Sikap</span>
                            <span class="text-sm font-medium">{{ $kpApplication->score->attitude }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Laporan</span>
                            <span class="text-sm font-medium">{{ $kpApplication->score->report }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Penguasaan</span>
                            <span class="text-sm font-medium">{{ $kpApplication->score->mastery }}/100</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Rata-rata</span>
                                <span>{{ $kpApplication->score->final_score }}/100</span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada nilai</p>
                @endif
            </div>
        </div>

        <!-- Seminar Score -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Nilai Seminar</h3>
            </div>
            <div class="p-6">
                @if($kpApplication->examinerSeminarScore)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Laporan</span>
                            <span class="text-sm font-medium">{{ $kpApplication->examinerSeminarScore->laporan }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Presentasi</span>
                            <span class="text-sm font-medium">{{ $kpApplication->examinerSeminarScore->presentasi }}/100</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Sikap</span>
                            <span class="text-sm font-medium">{{ $kpApplication->examinerSeminarScore->sikap }}/100</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Rata-rata</span>
                                <span>{{ $kpApplication->examinerSeminarScore->rata_rata }}/100</span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada nilai</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Final Score Summary -->
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Nilai Akhir</h3>
        </div>
        <div class="p-6">
            @php
                $supervisorScore = $kpApplication->supervisorScore->final_score ?? 0;
                $fieldScore = $kpApplication->score->final_score ?? 0;
                $seminarScore = $kpApplication->examinerSeminarScore->rata_rata ?? 0;
                $finalScore = ($supervisorScore * 0.4) + ($fieldScore * 0.4) + ($seminarScore * 0.2);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($supervisorScore, 2) }}</div>
                    <div class="text-sm text-blue-600">Dosen Pembimbing (40%)</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($fieldScore, 2) }}</div>
                    <div class="text-sm text-green-600">Pengawas Lapangan(40%)</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($seminarScore, 2) }}</div>
                    <div class="text-sm text-purple-600">Seminar (20%)</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($finalScore, 2) }}</div>
                    <div class="text-sm text-gray-600">Nilai Akhir</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
