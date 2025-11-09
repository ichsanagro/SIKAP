@extends('layouts.app')

@section('title', 'Seminar Students')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Mahasiswa Seminar KP</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen Penguji</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $application->student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->student->nim }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $application->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->statusBadgeClass() }}">
                                        {{ $application->statusText() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($application->examiner)
                                        {{ $application->examiner->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ Storage::url($application->kegiatan_harian_path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        Kegiatan Harian
                                    </a>
                                    <br>
                                    <a href="{{ Storage::url($application->bimbingan_kp_path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        Bimbingan KP
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('supervisor.seminar.show', $application) }}"
                                       class="text-blue-600 hover:text-blue-900">
                                        Lihat
                                    </a>
                                    @php
                                        $examinerScore = \App\Models\ExaminerSeminarScore::where('kp_application_id', $application->student->kpApplications->first()->id ?? null)
                                            ->where('examiner_id', Auth::id())
                                            ->first();
                                    @endphp
                                    @if($examinerScore)
                                        <br>
                                        <a href="{{ route('supervisor.seminar.scores.edit', $examinerScore) }}"
                                           class="text-orange-600 hover:text-orange-900">
                                            Ubah Nilai
                                        </a>
                                    @else
                                        <br>
                                        <a href="{{ route('supervisor.seminar.scores.create', ['application' => $application->student->kpApplications->first()->id ?? null]) }}"
                                           class="text-green-600 hover:text-green-900">
                                            Beri Nilai
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada mahasiswa seminar KP
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
