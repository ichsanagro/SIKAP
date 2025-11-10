@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Kuesioner</h1>
        <p class="text-sm md:text-base text-gray-600 mt-2">Kuesioner yang perlu Anda isi</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            @if($questionnaires->count() > 0)
                <div class="space-y-4">
                    @foreach($questionnaires as $questionnaire)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $questionnaire->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $questionnaire->description }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($questionnaire->target_role == 'MAHASISWA') bg-blue-100 text-blue-800
                                        @elseif($questionnaire->target_role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        {{ $questionnaire->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($questionnaire->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
                                        {{ $questionnaire->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $questionnaire->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    {{ $questionnaire->questions->count() }} pertanyaan
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($questionnaire->responses->isNotEmpty())
                                    <div class="text-center">
                                        <div class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Sudah Diisi
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500">
                                            {{ $questionnaire->responses->first()->submitted_at->format('d/m/Y H:i') }}
                                        </div>
                                        <a href="{{ request()->routeIs('supervisor.questionnaires.*') ? route('supervisor.questionnaires.show', $questionnaire) : route('questionnaires.show', $questionnaire) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                                            Lihat Jawaban
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ request()->routeIs('supervisor.questionnaires.*') ? route('supervisor.questionnaires.show', $questionnaire) : route('questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Isi Kuesioner
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kuesioner</h3>
                    <p class="mt-1 text-sm text-gray-500">Kuesioner akan muncul di sini ketika tersedia untuk role Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
