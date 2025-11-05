@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Nilai KP</h1>
<a href="{{ route('field.scores.create') }}" class="btn btn-primary mb-3">Tambah Nilai</a>

<div class="overflow-x-auto">
<table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
  <thead class="bg-gray-50">
  <tr>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Mahasiswa</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Disiplin dan Kehadiran</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tanggung Jawab terhadap Pekerjaan</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Etika dan komunikasi</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Kemampuan kerja sama</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Penguasaan materi dan tugas kerja</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Total Skor</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Rata-rata Skor</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nilai Huruf</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Aksi</th>
  </tr>
  </thead>
  <tbody class="divide-y divide-gray-200">
  @foreach($applications as $app)
    <tr class="hover:bg-gray-50">
      <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">{{ optional($app->student)->name ?? '-' }}</div>
        <div class="text-sm text-gray-500">{{ optional($app->student)->nim ?? '-' }}</div>
        <div class="text-xs text-gray-400">{{ optional($app->company)->name ?? '-' }}</div>
      </td>
      @if($app->score)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->score->discipline }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->score->skill }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->score->attitude }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->score->report }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->score->final_score }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $app->score->discipline + $app->score->skill + $app->score->attitude + $app->score->report }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $app->score->final_score }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
          @php
            $grade = '';
            $gradeClass = '';
            if ($app->score->final_score >= 85) { $grade = 'A'; $gradeClass = 'text-green-600 bg-green-100'; }
            elseif ($app->score->final_score >= 75) { $grade = 'B'; $gradeClass = 'text-blue-600 bg-blue-100'; }
            elseif ($app->score->final_score >= 65) { $grade = 'C'; $gradeClass = 'text-yellow-600 bg-yellow-100'; }
            elseif ($app->score->final_score >= 55) { $grade = 'D'; $gradeClass = 'text-orange-600 bg-orange-100'; }
            else { $grade = 'E'; $gradeClass = 'text-red-600 bg-red-100'; }
          @endphp
          <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $gradeClass }}">{{ $grade }}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <div class="flex space-x-2">
            <a href="{{ route('field.scores.show',$app->score) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
            <a href="{{ route('field.scores.edit',$app->score) }}" class="text-amber-600 hover:text-amber-900">Ubah</a>
            <form action="{{ route('field.scores.destroy',$app->score) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:text-red-900">Hapus</button>
            </form>
          </div>
        </td>
      @else
        <td colspan="8" class="px-6 py-4 text-center">
          <span class="text-gray-500 text-sm">Belum dinilai</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <a href="{{ route('field.scores.create', ['application' => $app->id]) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Beri Nilai
          </a>
        </td>
      @endif
    </tr>
  @endforeach
  </tbody>
</table>
</div>

<div class="mt-4">
{{ $applications->links() }}
</div>
@endsection
