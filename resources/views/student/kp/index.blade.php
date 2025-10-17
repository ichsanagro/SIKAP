@extends('layouts.app')

@section('content')
@include('student.partials.nav')

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold text-unibBlue">Pengajuan Kerja Praktek Saya</h1>
  <a href="{{ route('kp-applications.create') }}" class="btn-orange">Ajukan KP</a>
</div>

<div class="card overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="text-left text-gray-600">
      <tr>
        <th class="py-2 pr-4">Judul</th>
        <th class="py-2 pr-4">Pilihan</th>
        <th class="py-2 pr-4">Perusahaan</th>
        <th class="py-2 pr-4">Dosen Pembimbing</th>
        <th class="py-2 pr-4">Status</th>
        <th class="py-2">Aksi</th>
      </tr>
    </thead>
    <tbody class="align-top">
      @forelse($apps as $kp)
        <tr class="border-t">
          <td class="py-2 pr-4 font-medium">{{ $kp->title }}</td>
          <td class="py-2 pr-4">
            @if($kp->placement_option === '1') Opsi 1 (Batch 1)
            @elseif($kp->placement_option === '2') Opsi 2 (Batch 2)
            @else Opsi 3 (Mandiri)
            @endif
          </td>
          <td class="py-2 pr-4">
            @if(in_array($kp->placement_option, ['1','2']) && $kp->company)
              {{ $kp->company->name }}
            @elseif($kp->placement_option === '3')
              {{ $kp->custom_company_name ?? '-' }}
            @else
              -
            @endif
          </td>
          <td class="py-2 pr-4">
            {{ $kp->student->supervisor?->name ?? '-' }}
          </td>
          <td class="py-2 pr-4">
            <span class="px-2 py-1 rounded-xl text-xs
              @class([
                'bg-gray-100 text-gray-700' => $kp->status === 'DRAFT',
                'bg-yellow-100 text-yellow-800' => $kp->status === 'SUBMITTED',
                'bg-blue-100 text-blue-800' => $kp->status === 'VERIFIED_PRODI',
                'bg-green-100 text-green-800' => in_array($kp->status,['APPROVED','COMPLETED']),
                'bg-red-100 text-red-800' => $kp->status === 'REJECTED',
              ])
            ">
              {{ $kp->status }}
            </span>
          </td>
          <td class="py-2">
            <div class="flex flex-wrap gap-2">
              <a href="{{ route('kp-applications.show', $kp) }}" class="btn-primary px-3 py-1 text-xs">Lihat</a>
              @if($kp->status === 'DRAFT')
                <a href="{{ route('kp-applications.edit', $kp) }}" class="btn-orange px-3 py-1 text-xs">Edit</a>

                @if($kp->krs_path)
                  <form method="POST" action="{{ route('kp.submit', $kp) }}" onsubmit="return confirm('Kirim pengajuan ini?');">
                    @csrf
                    <button class="px-3 py-1 rounded-xl bg-green-600 text-white text-xs hover:opacity-90">Submit</button>
                  </form>
                @else
                  <span class="px-3 py-1 rounded-xl bg-gray-200 text-gray-600 text-xs">Upload KRS dulu</span>
                @endif
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada pengajuan. Klik “Ajukan KP”.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $apps->links() }}
  </div>
</div>
@endsection
