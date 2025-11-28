@extends('layouts.app')
@section('content')

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold text-unibBlue">Aktivitas Lapangan</h1>
  <a href="{{ route('activity-logs.create') }}" class="btn-orange">Catat Aktivitas</a>
</div>

<div class="card">
  <table class="min-w-full text-sm">
    <thead class="text-left text-gray-600"><tr>
      <th class="py-2 pr-4">Tanggal</th>
      <th class="py-2 pr-4">Deskripsi</th>
      <th class="py-2 pr-4">Status</th>
    </tr></thead>
    <tbody>
      @forelse($logs as $log)
        <tr class="border-t">
          <td class="py-2 pr-4">{{ \Illuminate\Support\Carbon::parse($log->date)->format('d M Y') }}</td>
          <td class="py-2 pr-4">{{ $log->description }}</td>
          <td class="py-2 pr-4">
            <span class="px-2 py-1 rounded-xl
              @if($log->status === 'APPROVED') bg-green-100 text-green-800
              @elseif($log->status === 'REVISION') bg-yellow-100 text-yellow-800
              @else bg-gray-100 text-gray-800 @endif">
              @if($log->status === 'PENDING')
                Menunggu
              @elseif($log->status === 'APPROVED')
                Disetujui
              @elseif($log->status === 'REVISION')
                Revisi
              @else
                {{ $log->status }}
              @endif
            </span>
          </td>
        </tr>
      @empty
        <tr><td colspan="3" class="py-6 text-center text-gray-500">Belum ada catatan.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection
