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
                        {{ $questionnaire->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($questionnaire->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2 bg-green-100 text-green-800">
                        Sudah Diisi
                    </span>
                </div>
                <div class="mt-2 text-sm text-gray-500">
                    Disubmit pada: {{ $existingResponse->submitted_at->format('d F Y, H:i') }}
                </div>
            </div>
            <div>
                <a href="{{ request()->routeIs('supervisor.questionnaires.*') ? route('supervisor.questionnaires.index') : route('questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali ke Daftar Kuesioner
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Jawaban Anda</h3>

            <div class="space-y-6">
                @foreach($questionnaire->questions->sortBy('order') as $index => $question)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="mb-3">
                        <h4 class="text-md font-medium text-gray-900">
                            {{ $index + 1 }}. {{ $question->question_text }}
                        </h4>
                    </div>

                    <div class="ml-4 bg-gray-50 p-3 rounded">
                        @php
                            $answer = $existingResponse->responses[$question->id] ?? null;
                        @endphp

                        @if($question->question_type == 'text' || $question->question_type == 'textarea' || $question->question_type == 'select')
                            <p class="text-gray-900">{{ $answer ?: 'Tidak ada jawaban' }}</p>
                        @elseif($question->question_type == 'radio')
                            <p class="text-gray-900">{{ $answer ?: 'Tidak ada jawaban' }}</p>
                        @elseif($question->question_type == 'checkbox')
                            @if($answer && is_array($answer))
                                <ul class="list-disc list-inside text-gray-900">
                                    @foreach($answer as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-900">Tidak ada jawaban</p>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
