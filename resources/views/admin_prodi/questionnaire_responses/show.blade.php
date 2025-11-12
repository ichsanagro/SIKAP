@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Tanggapan Kuesioner</h1>
                <p class="text-sm md:text-base text-gray-600 mt-2">{{ $response->template->title }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin-prodi.questionnaire-responses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Response Info -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tanggapan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Responden</label>
                    <div class="mt-1 text-sm text-gray-900">{{ $response->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $response->user->email }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                        @if($response->user->role == 'MAHASISWA') bg-blue-100 text-blue-800
                        @elseif($response->user->role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                        @else bg-orange-100 text-orange-800 @endif">
                        {{ $response->user->role == 'MAHASISWA' ? 'Mahasiswa' : ($response->user->role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Submit</label>
                    <div class="mt-1 text-sm text-gray-900">{{ $response->submitted_at->format('d F Y, H:i') }}</div>
                </div>
                @if($response->kpApplication)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Aplikasi KP</label>
                    <div class="mt-1 text-sm text-gray-900">{{ $response->kpApplication->company->name ?? 'N/A' }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Questionnaire Details -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Kuesioner</h3>
            <div class="mb-4">
                <h4 class="text-md font-medium text-gray-900">{{ $response->template->title }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ $response->template->description }}</p>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($response->template->target_role == 'MAHASISWA') bg-blue-100 text-blue-800
                        @elseif($response->template->target_role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                        @else bg-orange-100 text-orange-800 @endif">
                        Target: {{ $response->template->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($response->template->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Answers -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Jawaban</h3>

            @if($response->template->questions->count() > 0)
                <div class="space-y-6">
                    @foreach($response->template->questions->sortBy('order') as $index => $question)
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

                        <!-- Answer Display -->
                        <div class="ml-4 p-3 bg-gray-50 rounded-md">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban:</label>
                            <div class="text-sm text-gray-900">
                                @php
                                    $answer = $response->responses[$question->id] ?? '-';
                                @endphp

                                @if(is_array($answer))
                                    @if($question->question_type == 'checkbox')
                                        <ul class="list-disc list-inside">
                                            @foreach($answer as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ implode(', ', $answer) }}
                                    @endif
                                @else
                                    @if($question->question_type == 'textarea')
                                        <div class="whitespace-pre-wrap">{{ $answer }}</div>
                                    @else
                                        {{ $answer }}
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if(in_array($question->question_type, ['radio', 'checkbox', 'select']) && $question->options)
                            <div class="ml-4 mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-2">Pilihan yang tersedia:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600">
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
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pertanyaan</h3>
                    <p class="mt-1 text-sm text-gray-500">Kuesioner ini tidak memiliki pertanyaan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
