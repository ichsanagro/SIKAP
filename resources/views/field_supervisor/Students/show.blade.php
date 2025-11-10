@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Detail Mahasiswa KP</h1>

<div class="grid md:grid-cols-2 gap-4 text-sm">
  <div class="p-4 border rounded">
    <h2 class="font-semibold mb-2">Mahasiswa</h2>
    <p>Nama: {{ optional($application->student)->name ?? '-' }}</p>
    <p>NIM: {{ optional($application->student)->nim ?? '-' }}</p>
    <p>Email: {{ optional($application->student)->email ?? '-' }}</p>
  </div>
  <div class="p-4 border rounded">
    <h2 class="font-semibold mb-2">Instansi</h2>
    <p>Nama: {{ optional($application->company)->name ?? '-' }}</p>
    <p>Alamat: {{ optional($application->company)->address ?? '-' }}</p>
    <p>Periode: {{ $application->period ?? '-' }}</p>
    <p>Status: {{ $application->status ?? '-' }}</p>
  </div>
</div>

<!-- Aktivitas Mahasiswa Section -->
<div class="mt-6">
  <h2 class="text-lg font-semibold mb-4">Aktivitas Mahasiswa</h2>
  @if($activityLogs->count() > 0)
    <div class="space-y-3">
      @foreach($activityLogs as $log)
        <div class="p-4 border rounded-lg bg-gray-50">
          <div class="flex justify-between items-start mb-2">
            <div class="font-medium">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</div>
            <div class="flex items-center space-x-2">
              <span class="px-2 py-1 text-xs rounded-full
                @if($log->status === 'APPROVED') bg-green-100 text-green-800
                @elseif($log->status === 'REVISION') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $log->status }}
              </span>
              @if($log->status !== 'APPROVED')
                <form method="POST" action="{{ route('field.activity-logs.approve', $log) }}" class="inline">
                  @csrf
                  <button type="submit" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                    Approve
                  </button>
                </form>
              @endif
              @if($log->status === 'PENDING')
                <form method="POST" action="{{ route('field.activity-logs.revise', $log) }}" class="inline">
                  @csrf
                  <button type="submit" class="px-3 py-1 text-xs bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    Revisi
                  </button>
                </form>
              @endif
            </div>
          </div>
          <p class="text-sm text-gray-700 mb-2">{{ $log->description }}</p>
          @if($log->drive_link)
            <div class="text-sm">
              <a href="{{ $log->drive_link }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-external-link-alt mr-1"></i>Buka Link Drive
              </a>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  @else
    <div class="text-center py-8 text-gray-500">
      <i class="fas fa-history text-3xl mb-2"></i>
      <p>Belum ada aktivitas yang dicatat</p>
    </div>
  @endif
</div>

<div class="mt-4 space-x-2">
  <a href="{{ route('field.students.index') }}" class="text-blue-600">Kembali</a>
  <form action="{{ route('field.students.destroy', $application) }}" method="POST" class="inline"
        onsubmit="return confirm('Unassign mahasiswa ini dari Anda?')">
    @csrf @method('DELETE')
    <button class="text-red-600">Hapus (Unassign)</button>
  </form>
</div>
@endsection
