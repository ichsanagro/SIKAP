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
                        <th class="text-left p-4">Supervisor</th>
                        <th class="text-left p-4">Pengawas Lapangan</th>
                        <th class="text-left p-4">Nilai Supervisor</th>
                        <th class="text-left p-4">Nilai Pengawas</th>
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
                            <a href="{{ route('admin-prodi.recap-scores.show', $application) }}"
                               class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
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
