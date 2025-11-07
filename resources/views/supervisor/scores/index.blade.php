@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Nilai KP</h1>
<a href="{{ route('supervisor.scores.create') }}" class="btn btn-primary mb-3">Tambah Nilai</a>

<div class="overflow-x-auto">
<table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
  <thead class="bg-gray-50">
  <tr>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Mahasiswa</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Laporan Kerja Praktek</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Presentasi dan Pemahaman Materi</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Sikap dan Etika</th>
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
      @if($app->supervisorScore)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->supervisorScore->report }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->supervisorScore->presentation }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $app->supervisorScore->attitude }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $app->supervisorScore->report + $app->supervisorScore->presentation + $app->supervisorScore->attitude }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($app->supervisorScore->final_score, 2) }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
          @php
            $grade = $app->supervisorScore->grade;
            $gradeClass = '';
            if ($grade == 'A') { $gradeClass = 'text-green-600 bg-green-100'; }
            elseif ($grade == 'B') { $gradeClass = 'text-blue-600 bg-blue-100'; }
            elseif ($grade == 'C') { $gradeClass = 'text-yellow-600 bg-yellow-100'; }
            elseif ($grade == 'D') { $gradeClass = 'text-orange-600 bg-orange-100'; }
            else { $gradeClass = 'text-red-600 bg-red-100'; }
          @endphp
          <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $gradeClass }}">{{ $grade }}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <div class="flex space-x-2">
            <a href="{{ route('supervisor.scores.edit',$app->supervisorScore) }}" class="text-amber-600 hover:text-amber-900">Ubah</a>
            <form action="{{ route('supervisor.scores.destroy',$app->supervisorScore) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:text-red-900">Hapus</button>
            </form>
          </div>
        </td>
      @else
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <a href="{{ route('supervisor.scores.create', ['application' => $app->id]) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
