@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Mahasiswa Bimbingan (Pengawas Lapangan)</h1>

@if(session('success'))
  <div class="p-3 bg-green-100 text-green-800 rounded mb-3">{{ session('success') }}</div>
@endif

<table class="table-auto w-full text-sm">
  <thead>
    <tr class="border-b">
      <th class="text-left p-2">Nama</th>
      <th class="text-left p-2">NIM</th>
      <th class="text-left p-2">Instansi</th>
      <th class="text-left p-2">Status</th>
      <th class="text-left p-2">Aksi</th>
    </tr>
  </thead>
  <tbody>
  @forelse($apps as $app)
    <tr class="border-b">
      <td class="p-2">{{ optional($app->student)->name ?? '-' }}</td>
      <td class="p-2">{{ optional($app->student)->nim ?? '-' }}</td>
      <td class="p-2">{{ optional($app->company)->name ?? '-' }}</td>
      <td class="p-2">{{ $app->status ?? '-' }}</td>
      <td class="p-2 space-x-2">
        <a href="{{ route('field.students.show', $app) }}" class="text-blue-600">Lihat</a>
        <form action="{{ route('field.students.destroy', $app) }}" method="POST" class="inline"
              onsubmit="return confirm('Unassign mahasiswa ini dari Anda?')">
          @csrf @method('DELETE')
          <button class="text-red-600">Hapus (Unassign)</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="5" class="p-4 text-center text-gray-500">Belum ada mahasiswa bimbingan.</td></tr>
  @endforelse
  </tbody>
</table>

<div class="mt-4">
  {{ $apps->links() }}
</div>
@endsection
