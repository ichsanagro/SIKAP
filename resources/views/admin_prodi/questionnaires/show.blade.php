@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $questionnaire->title }}</h1>
                <p class="text-sm md:text-base text-gray-600 mt-2">{{ $questionnaire->description }}</p>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($questionnaire->target_role == 'MAHASISWA') bg-blue-100 text-blue-800
                        @elseif($questionnaire->target_role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                        @else bg-orange-100 text-orange-800 @endif">
                        Target: {{ $questionnaire->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($questionnaire->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
                        {{ $questionnaire->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $questionnaire->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin-prodi.questionnaires.edit', $questionnaire) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Ubah
                </a>
                <a href="{{ route('admin-prodi.questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pertanyaan</h3>

            @if($questionnaire->questions->count() > 0)
                <div class="space-y-6">
                    @foreach($questionnaire->questions as $index => $question)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-md font-medium text-gray-900">{{ $index + 1 }}. {{ $question->question_text }}</h4>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($question->question_type == 'text') bg-gray-100 text-gray-800
                                    @elseif($question->question_type == 'textarea') bg-blue-100 text-blue-800
                                    @elseif($question->question_type == 'radio') bg-green-100 text-green-800
                                    @elseif($question->question_type == 'checkbox') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $question->question_type == 'text' ? 'Teks Singkat' : ($question->question_type == 'textarea' ? 'Teks Panjang' : ($question->question_type == 'radio' ? 'Pilihan Ganda' : ($question->question_type == 'checkbox' ? 'Kotak Centang' : 'Dropdown'))) }}
                                </span>
                                @if($question->is_required)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Wajib
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(in_array($question->question_type, ['radio', 'checkbox', 'select']) && $question->options)
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                    @foreach($question->options as $option)
                                        <li>{{ $option }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pertanyaan</h3>
                    <p class="mt-1 text-sm text-gray-500">Pertanyaan akan muncul di sini setelah ditambahkan.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Respon</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $questionnaire->responses->count() }}</div>
                    <div class="text-sm text-gray-600">Total Respon</div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-900">{{ $questionnaire->responses->where('submitted_at', '>=', now()->startOfMonth())->count() }}</div>
                    <div class="text-sm text-blue-600">Bulan Ini</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-900">{{ $questionnaire->responses->where('submitted_at', '>=', now()->startOfWeek())->count() }}</div>
                    <div class="text-sm text-green-600">Minggu Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
