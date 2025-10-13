@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">
    @if(session('success'))
        <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg p-5">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Detail Pengajuan KP</h2>
            <span class="px-2 py-1 rounded text-xs
                @if($app->verification_status==='APPROVED') bg-green-100 text-green-700
                @elseif($app->verification_status==='REJECTED') bg-red-100 text-red-700
                @else bg-yellow-100 text-yellow-700 @endif">
                {{ $app->verification_status }}
            </span>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Mahasiswa</div>
                <div class="font-medium">{{ $app->student->name ?? '-' }}</div>
                <div class="text-gray-500">{{ $app->student->email ?? '' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Perusahaan</div>
                <div class="font-medium">
                    @if($app->company)
                        {{ $app->company->name }}
                    @else
                        {{ $app->custom_company_name ?? '-' }}
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold mb-2">Dokumen</h3>
            <ul class="list-disc ml-5 space-y-1 text-sm">
                @if(!empty($app->krs_path))
                    <li>KRS:
                        <a class="text-indigo-600 underline" href="{{ Storage::url($app->krs_path) }}" target="_blank">Lihat</a>
                    </li>
                @endif
                @if(!empty($app->surat_pengantar_path))
                    <li>Surat Pengantar:
                        <a class="text-indigo-600 underline" href="{{ Storage::url($app->surat_pengantar_path) }}" target="_blank">Lihat</a>
                    </li>
                @endif
                @if(!empty($app->proposal_path))
                    <li>Proposal:
                        <a class="text-indigo-600 underline" href="{{ Storage::url($app->proposal_path) }}" target="_blank">Lihat</a>
                    </li>
                @endif
                @if(empty($app->krs_path) && empty($app->surat_pengantar_path) && empty($app->proposal_path))
                    <li class="text-gray-500">Tidak ada dokumen terunggah.</li>
                @endif
            </ul>
        </div>
    </div>

    @if($app->verification_status === 'PENDING')
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="font-semibold mb-3">Verifikasi</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <form method="POST" action="{{ route('admin-prodi.verifications.approve', $app) }}" class="space-y-3">
                @csrf
                <label class="block text-sm">
                    <span class="text-gray-700">Catatan (opsional)</span>
                    <textarea name="notes" class="mt-1 w-full border rounded p-2" rows="3" placeholder="Catatan untuk mahasiswa (opsional)"></textarea>
                </label>
                <button class="px-4 py-2 bg-green-600 text-white rounded">ACC (APPROVE)</button>
            </form>

            <form method="POST" action="{{ route('admin-prodi.verifications.reject', $app) }}" class="space-y-3">
                @csrf
                <label class="block text-sm">
                    <span class="text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></span>
                    <textarea name="notes" class="mt-1 w-full border rounded p-2" rows="3" required placeholder="Tuliskan alasan singkat penolakan"></textarea>
                </label>
                <button class="px-4 py-2 bg-red-600 text-white rounded">Tolak (REJECT)</button>
            </form>
        </div>
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="font-semibold mb-2">Hasil Verifikasi</h3>
        <div class="text-sm">
            <div>Status: <span class="font-medium">{{ $app->verification_status }}</span></div>
            <div>Catatan: <span class="font-medium">{{ $app->verification_notes ?? '-' }}</span></div>
            <div>Verifier: <span class="font-medium">{{ $app->verifier->name ?? '-' }}</span></div>
            <div>Waktu: <span class="font-medium">{{ $app->verified_at?->format('d M Y H:i') ?? '-' }}</span></div>
        </div>
    </div>
    @endif

    <div>
        <a href="{{ route('admin-prodi.verifications.index') }}" class="text-gray-700 underline">← Kembali ke daftar</a>
    </div>
</div>
@endsection
