@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tanggapan Kuesioner: {{ $questionnaire->title }}</h1>
                <p class="text-sm md:text-base text-gray-600 mt-2">Lihat semua tanggapan untuk kuesioner ini</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin-prodi.questionnaire-responses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Lihat Semua Tanggapan
                </a>
                <a href="{{ route('admin-prodi.questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali ke Kuesioner
                </a>
            </div>
        </div>
    </div>

    <!-- Questionnaire Info -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kuesioner</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul</label>
                    <div class="mt-1 text-sm text-gray-900">{{ $questionnaire->title }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Target Role</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                        @if($questionnaire->target_role == 'MAHASISWA') bg-blue-100 text-blue-800
                        @elseif($questionnaire->target_role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                        @else bg-orange-100 text-orange-800 @endif">
                        {{ $questionnaire->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($questionnaire->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Tanggapan</label>
                    <div class="mt-1 text-sm text-gray-900">{{ $responses->total() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            @if($responses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responden</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($responses as $response)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $response->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $response->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($response->user->role == 'MAHASISWA') bg-blue-100 text-blue-800
                                        @elseif($response->user->role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        {{ $response->user->role == 'MAHASISWA' ? 'Mahasiswa' : ($response->user->role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $response->submitted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin-prodi.questionnaire-responses.show', $response) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $responses->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tanggapan</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada responden yang mengisi kuesioner ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
