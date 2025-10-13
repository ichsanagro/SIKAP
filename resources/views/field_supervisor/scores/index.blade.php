@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Nilai KP</h1>
<a href="{{ route('field.scores.create') }}" class="btn btn-primary mb-3">Tambah Nilai</a>

<table class="table-auto w-full">
  <thead>
  <tr>
    <th>Mahasiswa</th><th>Discipline</th><th>Skill</th><th>Attitude</th><th>Report</th><th>Final</th><th>Aksi</th>
  </tr>
  </thead>
  <tbody>
  @foreach($scores as $s)
    <tr>
      <td>{{ optional($s->application->student)->name ?? '-' }}</td>
      <td>{{ $s->discipline }}</td><td>{{ $s->skill }}</td><td>{{ $s->attitude }}</td><td>{{ $s->report }}</td>
      <td>{{ $s->final_score }}</td>
      <td class="space-x-2">
        <a href="{{ route('field.scores.show',$s) }}" class="text-blue-600">Lihat</a>
        <a href="{{ route('field.scores.edit',$s) }}" class="text-amber-600">Ubah</a>
        <form action="{{ route('field.scores.destroy',$s) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai?')">
          @csrf @method('DELETE')
          <button class="text-red-600">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

{{ $scores->links() }}
@endsection
