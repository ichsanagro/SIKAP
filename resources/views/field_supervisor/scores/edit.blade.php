@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Ubah Nilai Mahasiswa KP</h1>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
  <div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Mahasiswa</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
        <p class="mt-1 text-sm text-gray-900">{{ $score->application->student->name ?? '-' }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">NIM</label>
        <p class="mt-1 text-sm text-gray-900">{{ $score->application->student->nim ?? '-' }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Judul Kerja Praktik</label>
        <p class="mt-1 text-sm text-gray-900">{{ $score->application->title ?? '-' }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Tempat Kerja Praktik</label>
        <p class="mt-1 text-sm text-gray-900">{{ $score->application->company->name ?? $score->application->custom_company_name ?? '-' }}</p>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Waktu Pelaksanaan</label>
        <p class="mt-1 text-sm text-gray-900">
          @if($score->application->start_date)
            {{ \Carbon\Carbon::parse($score->application->start_date)->format('d M Y') }}
          @else
            -
          @endif
        </p>
      </div>
    </div>
  </div>
</div>

<form action="{{ route('field.scores.update', $score) }}" method="POST" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
  @csrf
  @method('PUT')
  <div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Penilaian Kerja Praktik</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="discipline" class="block text-sm font-medium text-gray-700">Disiplin dan Kehadiran <span class="text-red-500">*</span></label>
        <input type="number" name="discipline" id="discipline" min="1" max="100" required
               value="{{ old('discipline', $score->discipline) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               placeholder="1-100">
        @error('discipline')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="skill" class="block text-sm font-medium text-gray-700">Tanggung Jawab terhadap Pekerjaan <span class="text-red-500">*</span></label>
        <input type="number" name="skill" id="skill" min="1" max="100" required
               value="{{ old('skill', $score->skill) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               placeholder="1-100">
        @error('skill')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="attitude" class="block text-sm font-medium text-gray-700">Etika dan komunikasi <span class="text-red-500">*</span></label>
        <input type="number" name="attitude" id="attitude" min="1" max="100" required
               value="{{ old('attitude', $score->attitude) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               placeholder="1-100">
        @error('attitude')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="report" class="block text-sm font-medium text-gray-700">Kemampuan kerja sama <span class="text-red-500">*</span></label>
        <input type="number" name="report" id="report" min="1" max="100" required
               value="{{ old('report', $score->report) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               placeholder="1-100">
        @error('report')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="mastery" class="block text-sm font-medium text-gray-700">Penguasaan materi dan tugas kerja <span class="text-red-500">*</span></label>
        <input type="number" name="mastery" id="mastery" min="1" max="100" required
               value="{{ old('mastery', $score->mastery) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               placeholder="1-100">
        @error('mastery')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="mt-6">
      <label for="notes" class="block text-sm font-medium text-gray-700">Catatan/Saran Pembimbing Lapangan</label>
      <textarea name="notes" id="notes" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="Masukkan catatan atau saran untuk mahasiswa...">{{ old('notes', $score->notes) }}</textarea>
      @error('notes')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mt-6 bg-gray-50 p-4 rounded-md">
      <h3 class="text-sm font-medium text-gray-900 mb-2">Perhitungan Otomatis</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div>
          <span class="font-medium">Total Skor:</span>
          <span id="total-score" class="text-gray-900">{{ $score->discipline + $score->skill + $score->attitude + $score->report + $score->mastery }}</span>
        </div>
        <div>
          <span class="font-medium">Rata-rata Skor:</span>
          <span id="average-score" class="text-gray-900">{{ number_format($score->final_score, 2) }}</span>
        </div>
        <div>
          <span class="font-medium">Nilai Huruf:</span>
          @php
            $grade = '';
            if ($score->final_score >= 85) $grade = 'A';
            elseif ($score->final_score >= 75) $grade = 'B';
            elseif ($score->final_score >= 65) $grade = 'C';
            elseif ($score->final_score >= 55) $grade = 'D';
            else $grade = 'E';
          @endphp
          <span id="grade" class="font-semibold text-gray-900">{{ $grade }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="px-6 py-4 bg-gray-50 text-right">
    <a href="{{ route('field.scores.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
      Batal
    </a>
    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Update Nilai
    </button>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const inputs = ['discipline', 'skill', 'attitude', 'report', 'mastery'];
  const totalScoreEl = document.getElementById('total-score');
  const averageScoreEl = document.getElementById('average-score');
  const gradeEl = document.getElementById('grade');

  function calculateScores() {
    let total = 0;
    let count = 0;

    inputs.forEach(id => {
      const value = parseInt(document.getElementById(id).value) || 0;
      total += value;
      if (value > 0) count++;
    });

    const average = count > 0 ? (total / 5).toFixed(2) : '0.00';

    totalScoreEl.textContent = total;
    averageScoreEl.textContent = average;

    let grade = '-';
    if (average >= 85) grade = 'A';
    else if (average >= 75) grade = 'B';
    else if (average >= 65) grade = 'C';
    else if (average >= 55) grade = 'D';
    else if (average > 0) grade = 'E';

    gradeEl.textContent = grade;
  }

  inputs.forEach(id => {
    document.getElementById(id).addEventListener('input', calculateScores);
  });

  // Initial calculation
  calculateScores();
});
</script>
@endsection
