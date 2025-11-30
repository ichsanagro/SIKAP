@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rekap Nilai KP</h1>
            <p class="text-gray-600 mt-2">Kelola dan pantau nilai mahasiswa KP</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Daftar Nilai Mahasiswa ({{ $applications->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">Mahasiswa</th>
                        <th class="text-left p-4">NIM</th>
                        <th class="text-left p-4">Perusahaan</th>
                        <th class="text-left p-4">Dosen Pembimbing</th>
                        <th class="text-left p-4">Pengawas Lapangan</th>
                        <th class="text-left p-4">Nilai Dosen Pembimbing</th>
                        <th class="text-left p-4">Nilai Pengawas Lapangan </th>
                        <th class="text-left p-4">Nilai Seminar</th>
                        <th class="text-left p-4">Total</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($applications as $application)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 font-medium">{{ $application->student->name }}</td>
                        <td class="p-4">{{ $application->student->nim }}</td>
                        <td class="p-4">{{ $application->company->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ $application->supervisor->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ $application->fieldSupervisor->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ $application->supervisorScore->final_score ?? 'N/A' }}</td>
                        <td class="p-4">{{ $application->score->final_score ?? 'N/A' }}</td>
                        <td class="p-4">{{ $application->examinerSeminarScore->rata_rata ?? 'N/A' }}</td>
                        <td class="p-4 font-bold">
                            @php
                                $supervisorScore = $application->supervisorScore->final_score ?? 0;
                                $fieldScore = $application->score->final_score ?? 0;
                                $seminarScore = $application->examinerSeminarScore->rata_rata ?? 0;
                                $total = ($supervisorScore * 0.4) + ($fieldScore * 0.4) + ($seminarScore * 0.2);
                            @endphp
                            {{ number_format($total, 2) }}
                        </td>
                        <td class="p-4">
                            <a href="{{ route('admin-prodi.recap-scores.show', $application) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-8 text-center text-gray-500">Belum ada data mahasiswa yang tersedia.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
