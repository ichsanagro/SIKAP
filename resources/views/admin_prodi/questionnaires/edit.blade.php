@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Kuesioner</h1>
        <p class="text-sm md:text-base text-gray-600 mt-2">Edit kuesioner "{{ $questionnaire->title }}"</p>
    </div>

    <form method="POST" action="{{ route('admin-prodi.questionnaires.update', $questionnaire) }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Kuesioner</label>
                <input type="text" name="title" id="title" value="{{ old('title', $questionnaire->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="target_role" class="block text-sm font-medium text-gray-700">Target Pengisi</label>
                <select name="target_role" id="target_role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Pilih Target</option>
                    <option value="MAHASISWA" {{ old('target_role', $questionnaire->target_role) == 'MAHASISWA' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="DOSEN_SUPERVISOR" {{ old('target_role', $questionnaire->target_role) == 'DOSEN_SUPERVISOR' ? 'selected' : '' }}>Dosen Supervisor</option>
                    <option value="PENGAWAS_LAPANGAN" {{ old('target_role', $questionnaire->target_role) == 'PENGAWAS_LAPANGAN' ? 'selected' : '' }}>Pengawas Lapangan</option>
                </select>
                @error('target_role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $questionnaire->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Status Kuesioner</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $questionnaire->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan kuesioner ini</span>
                </label>
            </div>
            @error('is_active')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Pertanyaan</h3>
                <button type="button" id="add-question" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pertanyaan
                </button>
            </div>

            <div id="questions-container">
                @foreach($questionnaire->questions as $index => $question)
                <div class="question-item bg-gray-50 p-4 rounded-lg mb-4" data-question-id="{{ $question->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="text-md font-medium text-gray-900">Pertanyaan {{ $index + 1 }}</h4>
                        <button type="button" class="remove-question text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teks Pertanyaan</label>
                            <input type="text" name="questions[{{ $index + 1 }}][question_text]" value="{{ old('questions.' . ($index + 1) . '.question_text', $question->question_text) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                            <select name="questions[{{ $index + 1 }}][question_type]" class="question-type mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="text" {{ old('questions.' . ($index + 1) . '.question_type', $question->question_type) == 'text' ? 'selected' : '' }}>Teks Singkat</option>
                                <option value="textarea" {{ old('questions.' . ($index + 1) . '.question_type', $question->question_type) == 'textarea' ? 'selected' : '' }}>Teks Panjang</option>
                                <option value="radio" {{ old('questions.' . ($index + 1) . '.question_type', $question->question_type) == 'radio' ? 'selected' : '' }}>Pilihan Ganda (Radio)</option>
                                <option value="checkbox" {{ old('questions.' . ($index + 1) . '.question_type', $question->question_type) == 'checkbox' ? 'selected' : '' }}>Kotak Centang (Checkbox)</option>
                                <option value="select" {{ old('questions.' . ($index + 1) . '.question_type', $question->question_type) == 'select' ? 'selected' : '' }}>Dropdown</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Wajib Diisi</label>
                        <input type="checkbox" name="questions[{{ $index + 1 }}][is_required]" value="1" {{ old('questions.' . ($index + 1) . '.is_required', $question->is_required) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div class="options-container {{ in_array($question->question_type, ['radio', 'checkbox', 'select']) ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
                        <div class="options-list space-y-2">
                            @if($question->options)
                                @foreach($question->options as $optionIndex => $option)
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="questions[{{ $index + 1 }}][options][]" value="{{ old('questions.' . ($index + 1) . '.options.' . $optionIndex, $option) }}" placeholder="Pilihan {{ $optionIndex + 1 }}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" class="add-option text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                    @if($optionIndex > 0)
                                    <button type="button" class="remove-option text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="questions[{{ $index + 1 }}][options][]" placeholder="Pilihan 1" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" class="add-option text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin-prodi.questionnaires.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Update Kuesioner
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = {{ $questionnaire->questions->count() }};

    document.getElementById('add-question').addEventListener('click', function() {
        questionCount++;
        addQuestion(questionCount);
    });

    function addQuestion(index) {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item bg-gray-50 p-4 rounded-lg mb-4';
        questionDiv.innerHTML = `
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-md font-medium text-gray-900">Pertanyaan ${index}</h4>
                <button type="button" class="remove-question text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Teks Pertanyaan</label>
                    <input type="text" name="questions[${index}][question_text]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                    <select name="questions[${index}][question_type]" class="question-type mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="text">Teks Singkat</option>
                        <option value="textarea">Teks Panjang</option>
                        <option value="radio">Pilihan Ganda (Radio)</option>
                        <option value="checkbox">Kotak Centang (Checkbox)</option>
                        <option value="select">Dropdown</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Wajib Diisi</label>
                <input type="checkbox" name="questions[${index}][is_required]" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="options-container hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
                <div class="options-list space-y-2">
                    <div class="flex items-center space-x-2">
                        <input type="text" name="questions[${index}][options][]" placeholder="Pilihan 1" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="add-option text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(questionDiv);

        // Add event listeners
        const questionTypeSelect = questionDiv.querySelector('.question-type');
        const optionsContainer = questionDiv.querySelector('.options-container');
        const removeButton = questionDiv.querySelector('.remove-question');

        questionTypeSelect.addEventListener('change', function() {
            if (['radio', 'checkbox', 'select'].includes(this.value)) {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }
        });

        removeButton.addEventListener('click', function() {
            questionDiv.remove();
            updateQuestionNumbers();
        });

        // Add option functionality
        questionDiv.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-option')) {
                const optionsList = e.target.closest('.options-container').querySelector('.options-list');
                const optionDiv = document.createElement('div');
                optionDiv.className = 'flex items-center space-x-2';
                optionDiv.innerHTML = `
                    <input type="text" name="questions[${index}][options][]" placeholder="Pilihan ${optionsList.children.length + 1}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" class="remove-option text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;
                optionsList.appendChild(optionDiv);
            } else if (e.target.classList.contains('remove-option')) {
                e.target.closest('.flex').remove();
            }
        });
    }

    function updateQuestionNumbers() {
        const questions = document.querySelectorAll('.question-item h4');
        questions.forEach((h4, index) => {
            h4.textContent = `Pertanyaan ${index + 1}`;
        });
        questionCount = questions.length;
    }

    // Add event listeners to existing questions
    document.querySelectorAll('.question-type').forEach(select => {
        select.addEventListener('change', function() {
            const optionsContainer = this.closest('.question-item').querySelector('.options-container');
            if (['radio', 'checkbox', 'select'].includes(this.value)) {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('.remove-question').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.question-item').remove();
            updateQuestionNumbers();
        });
    });

    // Add option functionality to existing questions
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-option')) {
            const addButton = e.target.closest('.add-option');
            const optionsList = addButton.closest('.options-container').querySelector('.options-list');
            const questionItem = addButton.closest('.question-item');
            const questionIndex = Array.from(document.querySelectorAll('.question-item')).indexOf(questionItem) + 1;

            const optionDiv = document.createElement('div');
            optionDiv.className = 'flex items-center space-x-2';
            optionDiv.innerHTML = `
                <input type="text" name="questions[${questionIndex}][options][]" placeholder="Pilihan ${optionsList.children.length + 1}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <button type="button" class="remove-option text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            optionsList.appendChild(optionDiv);
        } else if (e.target.closest('.remove-option')) {
            e.target.closest('.remove-option').closest('.flex').remove();
        }
    });
});
</script>
@endsection
