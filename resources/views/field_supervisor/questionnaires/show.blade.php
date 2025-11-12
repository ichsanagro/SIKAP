@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $questionnaire->title }}</h1>
        <p class="text-sm md:text-base text-gray-600 mt-2">{{ $questionnaire->description }}</p>
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800">Kuesioner telah diselesaikan</p>
                    <p class="text-xs text-green-600">Dikirim pada {{ $existingResponse->submitted_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-5 sm:p-6 divide-y divide-gray-200">
            @foreach($questionnaire->questions as $question)
            <div class="py-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    {{ $question->question_text }}
                </h3>
                @if($question->description)
                    <p class="text-sm text-gray-600 mb-4">{{ $question->description }}</p>
                @endif

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Jawaban Anda:</p>
                    @php
                        $answer = $existingResponse->responses[$question->id] ?? null;
                    @endphp

                    @if($question->question_type === 'checkbox' && is_array($answer))
                        <ul class="list-disc list-inside text-sm text-gray-900">
                            @foreach($answer as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-900">{{ is_array($answer) ? implode(', ', $answer) : $answer }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('field.questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Kembali ke Daftar Kuesioner
            </a>
        </div>
    </div>
</div>
@endsection
