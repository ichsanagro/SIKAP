@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $questionnaire->title }}</h1>
        <p class="text-sm md:text-base text-gray-600 mt-2">{{ $questionnaire->description }}</p>
        <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($questionnaire->target_role == 'MAHASISWA') bg-blue-100 text-blue-800
                @elseif($questionnaire->target_role == 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                @else bg-orange-100 text-orange-800 @endif">
                {{ $questionnaire->target_role == 'MAHASISWA' ? 'Mahasiswa' : ($questionnaire->target_role == 'DOSEN_SUPERVISOR' ? 'Dosen Supervisor' : 'Pengawas Lapangan') }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ request()->routeIs('supervisor.questionnaires.*') ? route('supervisor.questionnaires.store', $questionnaire) : route('questionnaires.store', $questionnaire) }}" class="bg-white rounded-lg shadow p-6">
        @csrf

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Ada kesalahan:</strong>
                <ul class="mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            @foreach($questionnaire->questions->sortBy('order') as $index => $question)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="mb-3">
                    <h4 class="text-md font-medium text-gray-900">
                        {{ $index + 1 }}. {{ $question->question_text }}
                        @if($question->is_required)
                            <span class="text-red-500">*</span>
                        @endif
                    </h4>
                </div>

                <div class="ml-4">
                    @if($question->question_type == 'text')
                        <input type="text" name="question_{{ $question->id }}" value="{{ old('question_' . $question->id) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" {{ $question->is_required ? 'required' : '' }}>
                    @elseif($question->question_type == 'textarea')
                        <textarea name="question_{{ $question->id }}" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" {{ $question->is_required ? 'required' : '' }}>{{ old('question_' . $question->id) }}</textarea>
                    @elseif($question->question_type == 'radio')
                        @if($question->options)
                            @foreach($question->options as $option)
                            <div class="flex items-center">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}" id="radio_{{ $question->id }}_{{ $loop->index }}" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('question_' . $question->id) == $option ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}>
                                <label for="radio_{{ $question->id }}_{{ $loop->index }}" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ $option }}
                                </label>
                            </div>
                            @endforeach
                        @endif
                    @elseif($question->question_type == 'checkbox')
                        @if($question->options)
                            @foreach($question->options as $optionIndex => $option)
                            <div class="flex items-center">
                                <input type="checkbox" name="question_{{ $question->id }}[]" value="{{ $option }}" id="checkbox_{{ $question->id }}_{{ $optionIndex }}" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ in_array($option, old('question_' . $question->id, [])) ? 'checked' : '' }}>
                                <label for="checkbox_{{ $question->id }}_{{ $optionIndex }}" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ $option }}
                                </label>
                            </div>
                            @endforeach
                        @endif
                    @elseif($question->question_type == 'select')
                        <select name="question_{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" {{ $question->is_required ? 'required' : '' }}>
                            <option value="">Pilih jawaban</option>
                            @if($question->options)
                                @foreach($question->options as $option)
                                <option value="{{ $option }}" {{ old('question_' . $question->id) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            @endif
                        </select>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ request()->routeIs('supervisor.questionnaires.*') ? route('supervisor.questionnaires.index') : route('questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Kirim Kuesioner
            </button>
        </div>
    </form>
</div>
@endsection
