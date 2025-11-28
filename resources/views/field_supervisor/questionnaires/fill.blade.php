@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $questionnaire->title }}</h1>
        <p class="text-sm md:text-base text-gray-600 mt-2">{{ $questionnaire->description }}</p>
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
        <form action="{{ route('field.questionnaires.store', $questionnaire) }}" method="POST" class="divide-y divide-gray-200">
            @csrf
            <div class="px-4 py-5 sm:p-6">
                @foreach($questionnaire->questions as $question)
                <div class="py-6 {{ !$loop->first ? 'border-t border-gray-200' : '' }}">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            {{ $question->question_text }}
                            @if($question->is_required)
                                <span class="text-red-500">*</span>
                            @endif
                        </h3>
                        @if($question->description)
                            <p class="text-sm text-gray-600">{{ $question->description }}</p>
                        @endif
                    </div>

                    @if($question->question_type === 'text')
                        <input type="text" name="responses[{{ $question->id }}]" value="{{ old('responses.' . $question->id) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               @if($question->is_required) required @endif>
                    @elseif($question->question_type === 'textarea')
                        <textarea name="responses[{{ $question->id }}]" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                  @if($question->is_required) required @endif>{{ old('responses.' . $question->id) }}</textarea>
                    @elseif($question->question_type === 'radio')
                        @if($question->options)
                            @php
                                $options = is_array($question->options) ? $question->options : explode(',', $question->options);
                            @endphp
                            @foreach($options as $option)
                                <div class="flex items-center">
                                    <input type="radio" name="responses[{{ $question->id }}]" value="{{ trim($option) }}"
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                           @if(old('responses.' . $question->id) == trim($option)) checked @endif
                                           @if($question->is_required) required @endif>
                                    <label class="ml-3 block text-sm font-medium text-gray-700">{{ trim($option) }}</label>
                                </div>
                            @endforeach
                        @endif
                    @elseif($question->question_type === 'checkbox')
                        @if($question->options)
                            @php
                                $options = is_array($question->options) ? $question->options : explode(',', $question->options);
                            @endphp
                            @foreach($options as $option)
                                <div class="flex items-center">
                                    <input type="checkbox" name="responses[{{ $question->id }}][]" value="{{ trim($option) }}"
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                           @if(is_array(old('responses.' . $question->id)) && in_array(trim($option), old('responses.' . $question->id))) checked @endif>
                                    <label class="ml-3 block text-sm font-medium text-gray-700">{{ trim($option) }}</label>
                                </div>
                            @endforeach
                        @endif
                    @elseif($question->question_type === 'select')
                        <select name="responses[{{ $question->id }}]"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                @if($question->is_required) required @endif>
                            <option value="">Pilih jawaban</option>
                            @if($question->options)
                                @php
                                    $options = is_array($question->options) ? $question->options : explode(',', $question->options);
                                @endphp
                                @foreach($options as $option)
                                    <option value="{{ trim($option) }}" @if(old('responses.' . $question->id) == trim($option)) selected @endif>{{ trim($option) }}</option>
                                @endforeach
                            @endif
                        </select>
                    @endif

                    @error('responses.' . $question->id)
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('field.questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Kuesioner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
