@extends('layouts.app')
@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Kuesioner Pasca-KP</h2>

  <form method="POST" action="{{ route('questionnaire.store', $kp) }}" class="space-y-4">
    @csrf

    <div>
      <label class="block font-semibold">1) Seberapa sesuai pekerjaan KP dengan materi kuliah?</label>
      <select name="answers[q1]" class="mt-1 w-full border rounded-xl p-3" required>
        <option value="1">1 - Tidak sesuai</option>
        <option value="2">2</option>
        <option value="3">3 - Cukup</option>
        <option value="4">4</option>
        <option value="5">5 - Sangat sesuai</option>
      </select>
    </div>

    <div>
      <label class="block font-semibold">2) Masukan untuk Prodi</label>
      <textarea name="answers[q2]" rows="4" class="mt-1 w-full border rounded-xl p-3"></textarea>
    </div>

    <div class="pt-2">
      <button class="btn-primary">Kirim Kuesioner</button>
    </div>
  </form>
</div>
@endsection
