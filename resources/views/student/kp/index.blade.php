@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold text-unibBlue">Pengajuan Kerja Praktik Saya</h1>
  @php
    $hasActiveApplication = $apps->contains(function ($app) {
      return $app->status !== 'REJECTED';
    });
  @endphp
  @if(!$hasActiveApplication)
    <a href="{{ route('kp-applications.create') }}" class="btn-orange">Ajukan KP</a>
  @else
    <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed" title="Anda sudah memiliki pengajuan KP yang sedang diproses">Ajukan KP</span>
  @endif
</div>

<div class="card overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="text-left text-gray-600">
      <tr>
        <th class="py-2 pr-4">Judul</th>
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
              {{ match($kp->status) {
                'APPROVED' => 'Disetujui',
                'SUBMITTED' => 'Diserahkan',
                'REJECTED' => 'Ditolak',
                default => $kp->status
              } }}
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
              @if(in_array($kp->status, ['ASSIGNED_SUPERVISOR','APPROVED','COMPLETED','VERIFIED_PRODI']))
                <a href="{{ route('mentoring-logs.index') }}" class="btn-orange px-3 py-1 text-xs">Mulai Bimbingan</a>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada pengajuan. Klik “Ajukan KP”.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $apps->links() }}
  </div>
</div>
@endsection
