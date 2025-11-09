@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6">
        <a href="{{ route('supervisor.verifications.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke daftar verifikasi
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan Judul KP</h1>
        </div>

        <div class="px-6 py-6">
            <!-- Student Info -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIM</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->nim }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->student->email }}</p>
                    </div>
                </div>
            </div>

            <!-- KP Application Details -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pengajuan KP</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul KP</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilihan Tempat</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($kpApplication->placement_option === '1') Opsi 1 (Prodi - Batch 1)
                                @elseif($kpApplication->placement_option === '2') Opsi 2 (Prodi - Batch 2)
                                @else Opsi 3 (Cari Sendiri)
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perusahaan</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($kpApplication->company)
                                    {{ $kpApplication->company->name }}
                                @elseif($kpApplication->custom_company_name)
                                    {{ $kpApplication->custom_company_name }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($kpApplication->custom_company_address)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Perusahaan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->custom_company_address }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $kpApplication->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($kpApplication->status === 'SUBMITTED') bg-yellow-100 text-yellow-800
                                @elseif($kpApplication->status === 'VERIFIED_PRODI') bg-blue-100 text-blue-800
                                @elseif($kpApplication->status === 'APPROVED') bg-green-100 text-green-800
                                @elseif($kpApplication->status === 'REJECTED') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $kpApplication->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h2>
                <div class="space-y-3">
                    @if($kpApplication->krs_drive_link)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-900">KRS</span>
                            </div>
                            <a href="{{ $kpApplication->krs_drive_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">Buka Link</a>
                        </div>
                    @endif

                    @if($kpApplication->proposal_drive_link)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-900">Proposal</span>
                            </div>
                            <a href="{{ $kpApplication->proposal_drive_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">Buka Link</a>
                        </div>
                    @endif

                    @if($kpApplication->approval_path)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-900">Surat Persetujuan Instansi</span>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Unduh</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($kpApplication->status === 'SUBMITTED')
            <div class="border-t pt-6">
                <div class="flex justify-end space-x-3">
                    <form method="POST" action="{{ route('supervisor.verifications.reject', $kpApplication) }}" class="inline">
                        @csrf
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Berikan alasan penolakan..." required></textarea>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                Tolak
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('supervisor.verifications.approve', $kpApplication) }}" class="inline">
                        @csrf
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Berikan catatan jika ada..."></textarea>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">
                                Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
