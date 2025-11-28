@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ubah Evaluasi</h1>
            <p class="text-gray-600 mt-2">Perbarui evaluasi dan feedback mahasiswa KP</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('field.evaluations.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('field.evaluations.update', $evaluation) }}">
            @csrf
            @method('PUT')

            <!-- Student Info Display -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Informasi Mahasiswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium">Nama:</span>
                        <span class="text-gray-700 ml-2">{{ optional($evaluation->application->student)->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Instansi:</span>
                        <span class="text-gray-700 ml-2">{{ optional($evaluation->application->company)->name ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Rating (Opsional)
                </label>
                <div class="flex items-center space-x-2">
                    <div class="flex text-gray-300" id="rating_stars">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-8 h-8 cursor-pointer hover:text-yellow-400 transition-colors {{ $evaluation->rating && $evaluation->rating >= $i * 20 ? 'text-yellow-400' : 'text-gray-300' }}" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 ml-2" id="rating_text">
                        @if($evaluation->rating)
                            {{ $evaluation->rating }}/100 ({{ ceil($evaluation->rating / 20) }} bintang)
                        @else
                            Belum dinilai
                        @endif
                    </span>
                </div>
                <input type="hidden" name="rating" id="rating_input" value="{{ $evaluation->rating }}">
                <p class="mt-1 text-sm text-gray-500">Klik bintang untuk memberikan rating (0-100)</p>
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Evaluation -->
            <div class="mb-6">
                <label for="evaluation" class="block text-sm font-medium text-gray-700 mb-2">
                    Evaluasi <span class="text-red-500">*</span>
                </label>
                <textarea name="evaluation" id="evaluation" rows="4"
                          placeholder="Berikan evaluasi mendalam terhadap kinerja mahasiswa selama KP..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          required maxlength="2000">{{ old('evaluation', $evaluation->evaluation) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter. Jelaskan kekuatan dan area yang perlu diperbaiki.</p>
                @error('evaluation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Feedback -->
            <div class="mb-6">
                <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                    Feedback & Saran
                </label>
                <textarea name="feedback" id="feedback" rows="3"
                          placeholder="Berikan feedback konstruktif dan saran untuk pengembangan mahasiswa..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          maxlength="1000">{{ old('feedback', $evaluation->feedback) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter. Opsional, berikan saran untuk improvement.</p>
                @error('feedback')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('field.evaluations.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Evaluasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('#rating_stars svg');
    const ratingText = document.getElementById('rating_text');
    const ratingInput = document.getElementById('rating_input');

    // Handle star rating
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const score = rating * 20; // Convert 1-5 stars to 20-100 scale

            // Update visual
            ratingStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });

            // Update text and hidden input
            ratingText.textContent = `${score}/100 (${rating} bintang)`;
            ratingInput.value = score;
        });
    });
});
</script>
@endsection
