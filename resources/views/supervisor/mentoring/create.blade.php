@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Catatan Bimbingan</h1>
            <p class="text-gray-600 mt-2">Buat catatan bimbingan baru untuk mahasiswa</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('supervisor.mentoring.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('supervisor.mentoring.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Student Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    Pilih Mahasiswa <span class="text-red-500">*</span>
                </label>

                <!-- Student Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    @foreach($applications->groupBy('student_id') as $studentApps)
                        @php $student = $studentApps->first()->student; @endphp
                        <div class="student-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all duration-200"
                             data-student-id="{{ $student->id }}"
                             data-kp-options='{!! json_encode($studentApps->map(function($app) {
                                 return [
                                     "id" => $app->id,
                                     "title" => $app->title,
                                     "company" => $app->company->name ?? "Belum ada perusahaan"
                                 ];
                             })) !!}'>
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-blue-600">{{ substr($student->name, 0, 2) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $student->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $student->nim }}</p>
                                </div>
                                <div class="ml-2">
                                    <input type="radio" name="student_id" value="{{ $student->id }}"
                                           class="student-radio w-4 h-4 text-blue-600 focus:ring-blue-500"
                                           {{ old('student_id') == $student->id ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600">
                                <p><strong>Prodi:</strong> {{ $student->prodi ?? 'N/A' }}</p>
                                <p><strong>Perusahaan:</strong> {{ $studentApps->first()->company->name ?? 'Belum ada perusahaan' }}</p>
                                <p><strong>KP:</strong> {{ $studentApps->count() }} aplikasi</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Selected Student Display -->
                <div id="selected_student_display" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-blue-800" id="selected_student_text"></span>
                    </div>
                </div>

                @error('student_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- KP Application Selection -->
            <div class="mb-6">
                <label for="kp_application_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kerja Praktek <span class="text-red-500">*</span>
                </label>
                <select name="kp_application_id" id="kp_application_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <option value="">-- Pilih Kerja Praktek --</option>
                </select>
                @error('kp_application_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Auto-populated Title Display -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Kerja Praktek
                </label>
                <div id="kp_title_display" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900">
                    Pilih mahasiswa dan KP terlebih dahulu
                </div>
            </div>

            <!-- Date -->
            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required max="{{ date('Y-m-d') }}">
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Topic -->
            <div class="mb-6">
                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                    Topik Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="topic" id="topic" value="{{ old('topic') }}"
                       placeholder="Masukkan topik bimbingan"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required maxlength="1000">
                @error('topic')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes for Student -->
            <div class="mb-6">
                <label for="student_notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan untuk Mahasiswa
                </label>
                <textarea name="student_notes" id="student_notes" rows="4"
                          placeholder="Berikan catatan atau feedback khusus untuk mahasiswa"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          maxlength="2000">{{ old('student_notes') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter. Catatan ini akan dapat dilihat oleh mahasiswa.</p>
                @error('student_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Internal Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Internal (Opsional)
                </label>
                <textarea name="notes" id="notes" rows="4"
                          placeholder="Catatan internal untuk dosen pembimbing (tidak akan dilihat mahasiswa)"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          maxlength="5000">{{ old('notes') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maksimal 5000 karakter. Catatan ini hanya untuk internal dosen.</p>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attachment -->
            <div class="mb-6">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input type="file" name="attachment" id="attachment"
                       accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Format yang didukung: PDF, JPG, JPEG, PNG. Maksimal 5MB</p>
                @error('attachment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('supervisor.mentoring.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kpSelect = document.getElementById('kp_application_id');
    const titleDisplay = document.getElementById('kp_title_display');
    const selectedStudentDisplay = document.getElementById('selected_student_display');
    const selectedStudentText = document.getElementById('selected_student_text');
    const studentCards = document.querySelectorAll('.student-card');
    const studentRadios = document.querySelectorAll('.student-radio');

    // Handle student card clicks
    studentCards.forEach(card => {
        card.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const studentName = this.querySelector('h3').textContent;
            const studentNim = this.querySelector('.text-xs.text-gray-500').textContent;
            const kpOptions = this.getAttribute('data-kp-options');

            // Update radio button
            const radio = this.querySelector('.student-radio');
            radio.checked = true;

            // Update selected student display
            selectedStudentText.textContent = `Mahasiswa dipilih: ${studentName} (${studentNim})`;
            selectedStudentDisplay.classList.remove('hidden');

            // Clear KP select
            kpSelect.innerHTML = '<option value="">-- Pilih Kerja Praktek --</option>';
            titleDisplay.textContent = 'Pilih mahasiswa dan KP terlebih dahulu';

            // Populate KP options
            if (kpOptions) {
                const options = JSON.parse(kpOptions);
                options.forEach(function(kp) {
                    const option = document.createElement('option');
                    option.value = kp.id;
                    option.textContent = kp.title + ' (' + kp.company + ')';
                    option.setAttribute('data-title', kp.title);
                    kpSelect.appendChild(option);
                });
            }

            // Visual feedback for selected card
            studentCards.forEach(c => c.classList.remove('border-blue-500', 'bg-blue-50'));
            this.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    // Handle radio button changes
    studentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const card = this.closest('.student-card');
            const studentName = card.querySelector('h3').textContent;
            const studentNim = card.querySelector('.text-xs.text-gray-500').textContent;
            const kpOptions = card.getAttribute('data-kp-options');

            // Update selected student display
            selectedStudentText.textContent = `Mahasiswa dipilih: ${studentName} (${studentNim})`;
            selectedStudentDisplay.classList.remove('hidden');

            // Clear KP select
            kpSelect.innerHTML = '<option value="">-- Pilih Kerja Praktek --</option>';
            titleDisplay.textContent = 'Pilih mahasiswa dan KP terlebih dahulu';

            // Populate KP options
            if (kpOptions) {
                const options = JSON.parse(kpOptions);
                options.forEach(function(kp) {
                    const option = document.createElement('option');
                    option.value = kp.id;
                    option.textContent = kp.title + ' (' + kp.company + ')';
                    option.setAttribute('data-title', kp.title);
                    kpSelect.appendChild(option);
                });
            }

            // Visual feedback for selected card
            studentCards.forEach(c => c.classList.remove('border-blue-500', 'bg-blue-50'));
            card.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    kpSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const title = selectedOption.getAttribute('data-title');
        titleDisplay.textContent = title || 'Pilih mahasiswa dan KP terlebih dahulu';
    });

    // Check if a student is already selected (for form validation errors)
    const checkedRadio = document.querySelector('.student-radio:checked');
    if (checkedRadio) {
        const card = checkedRadio.closest('.student-card');
        const studentName = card.querySelector('h3').textContent;
        const studentNim = card.querySelector('.text-xs.text-gray-500').textContent;
        selectedStudentText.textContent = `Mahasiswa dipilih: ${studentName} (${studentNim})`;
        selectedStudentDisplay.classList.remove('hidden');
        card.classList.add('border-blue-500', 'bg-blue-50');
    }
});
</script>
@endsection
