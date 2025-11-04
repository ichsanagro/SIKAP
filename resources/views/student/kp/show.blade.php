@extends('layouts.app')
@section('content')

<div class="grid md:grid-cols-2 gap-6">
  <div class="card">
    <h2 class="text-xl font-bold mb-3">{{ $kp->title }}</h2>

    <dl class="text-sm space-y-2">
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Pilihan</dt>
        <dd class="col-span-2">
          @if($kp->placement_option==='1') Opsi 1 (Prodi/Batch 1)
          @elseif($kp->placement_option==='2') Opsi 2 (Prodi/Batch 2)
          @else Opsi 3 (Mandiri)
          @endif
        </dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Perusahaan</dt>
        <dd class="col-span-2">
          @if(in_array($kp->placement_option,['1','2']) && $kp->company) {{ $kp->company->name }}
          @elseif($kp->placement_option==='3') {{ $kp->custom_company_name ?? '-' }}
          @else - @endif
        </dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Mulai</dt>
        <dd class="col-span-2">{{ $kp->start_date?->format('d M Y') ?? '-' }}</dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Status</dt>
        <dd class="col-span-2">
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
        </dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Pembimbing</dt>
        <dd class="col-span-2">{{ $kp->supervisor?->name ?? '-' }}</dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Pengawas Lapangan</dt>
        <dd class="col-span-2">{{ $kp->fieldSupervisor?->name ?? '-' }}</dd>
      </div>
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">KRS</dt>
        <dd class="col-span-2">
          @if($kp->krs_path)
            <a class="text-unibBlue underline" href="{{ route('kp.krs.download', $kp) }}">Lihat/Unduh KRS</a>
          @else
            <span class="text-red-600">Belum diunggah</span>
          @endif
        </dd>
      </div>
      @if($kp->notes)
      <div class="grid grid-cols-3">
        <dt class="text-gray-500">Catatan Verifikator</dt>
        <dd class="col-span-2">{{ $kp->notes }}</dd>
      </div>
      @endif
    </dl>

    <div class="mt-4 flex gap-2">
      @if($kp->status==='DRAFT')
        <a href="{{ route('kp-applications.edit', $kp) }}" class="btn-orange">Edit Draft</a>
        @if($kp->krs_path)
          <form method="POST" action="{{ route('kp.submit', $kp) }}" onsubmit="return confirm('Kirim pengajuan ini?');">
            @csrf
            <button class="btn-primary">Submit</button>
          </form>
        @else
          <span class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600">Upload KRS dulu</span>
        @endif
      @endif

      @if(in_array($kp->status,['ASSIGNED_SUPERVISOR','APPROVED','COMPLETED','VERIFIED_PRODI']))
        <a href="{{ route('mentoring-logs.index') }}" class="btn-primary">Mulai Bimbingan</a>
        <a href="{{ route('activity-logs.index') }}" class="btn-orange">Catat Aktivitas</a>
      @endif
    </div>
  </div>

  <div class="card">
    <h3 class="font-semibold mb-2">Aksi Cepat</h3>
    <ul class="list-disc pl-6 text-sm text-gray-700 space-y-1">
      <li>Unggah KRS sebelum menekan Submit.</li>
      <li>Setelah diverifikasi Prodi, pembimbing akan ditetapkan.</li>
      <li>Catat bimbingan/aktivitas secara berkala; unggah laporan & isi kuesioner.</li>
    </ul>
  </div>
</div>
@endsection
