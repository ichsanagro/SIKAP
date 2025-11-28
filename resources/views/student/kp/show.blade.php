@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-8">
  <div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
      <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li>
          <a href="{{ route('kp-applications.index') }}" class="hover:text-blue-600">Pengajuan KP Saya</a>
        </li>
        <li>/</li>
        <li class="text-gray-900">{{ Str::limit($kp->title, 30) }}</li>
      </ol>
    </nav>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <div class="flex justify-between items-start">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $kp->title }}</h1>
          <p class="text-gray-600">Pengajuan Kerja Praktik</p>
          <div class="mt-3 text-sm text-gray-500">
            <p>Dibuat: {{ $kp->created_at->format('d M Y') }}</p>
            <p>Diperbarui: {{ $kp->updated_at->diffForHumans() }}</p>
          </div>
        </div>
        <div class="text-right">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            @if($kp->status === 'APPROVED') bg-green-100 text-green-800
            @elseif($kp->status === 'SUBMITTED') bg-yellow-100 text-yellow-800
            @elseif($kp->status === 'REJECTED') bg-red-100 text-red-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ match($kp->status) {
              'APPROVED' => 'Disetujui',
              'SUBMITTED' => 'Diserahkan',
              'REJECTED' => 'Ditolak',
              default => $kp->status
            } }}
          </span>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Details -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold mb-4 text-gray-900">Detail Pengajuan</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
              <p class="text-sm text-gray-900">
                @if(in_array($kp->placement_option,['1','2']) && $kp->company) {{ $kp->company->name }}
                @elseif($kp->placement_option==='3') {{ $kp->custom_company_name ?? '-' }}
                @else - @endif
              </p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
              <p class="text-sm text-gray-900">{{ $kp->start_date?->format('d M Y') ?? '-' }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
              <p class="text-sm text-gray-900">{{ $kp->supervisor?->name ?? '-' }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Pengawas Lapangan</label>
              <p class="text-sm text-gray-900">{{ $kp->fieldSupervisor?->name ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen KRS</label>
              <div class="text-sm">
                @if($kp->krs_path)
                  <a href="{{ route('kp.krs.download', $kp) }}" class="text-blue-600 hover:text-blue-800 underline">
                    Lihat/Unduh KRS
                  </a>
                @else
                  <span class="text-gray-500">Belum diunggah</span>
                @endif
              </div>
            </div>
          </div>

          @if($kp->notes)
          <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <label class="block text-sm font-medium text-yellow-800 mb-2">Catatan Verifikator</label>
            <p class="text-sm text-yellow-700">{{ $kp->notes }}</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Actions -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-900">Aksi</h2>

        <div class="space-y-3">
          @if($kp->status === 'DRAFT')
            <a href="{{ route('kp-applications.edit', $kp) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z"/>
              </svg>
              Ubah Draft
            </a>

            @if($kp->krs_path)
              <form method="POST" action="{{ route('kp.submit', $kp) }}" onsubmit="return confirm('Kirim pengajuan ini?');" class="w-full">
                @csrf
                <button class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                  Submit Pengajuan
                </button>
              </form>
            @else
              <div class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Upload KRS Terlebih Dahulu
              </div>
            @endif
          @endif

          @if(in_array($kp->status, ['ASSIGNED_SUPERVISOR', 'APPROVED', 'COMPLETED', 'VERIFIED_PRODI']))
            <a href="{{ route('mentoring-logs.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 011-1z" clip-rule="evenodd"/>
              </svg>
              Mulai Bimbingan
            </a>

            <a href="{{ route('activity-logs.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
              </svg>
              Catat Aktivitas Lapangan
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
