@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Pengajuan</h1>
            <p class="text-gray-600 mt-2">Kelola semua pengajuan KP</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Kembali ke Dasbor
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Semua Pengajuan ({{ $applications->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Mahasiswa</th>
                        <th class="text-left p-4">Judul</th>
                        <th class="text-left p-4">Perusahaan</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Supervisor</th>
                        <th class="text-left p-4">Supervisor Lapangan</th>
                        <th class="text-left p-4">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($applications as $app)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $app->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $app->student->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $app->student->nim ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ Str::limit($app->title, 30) }}</td>
                        <td class="p-4">
                            @if($app->company)
                                {{ $app->company->name }}
                            @else
                                {{ Str::limit($app->custom_company_name, 20) }}
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($app->verification_status === 'APPROVED') bg-green-100 text-green-800
                                @elseif($app->verification_status === 'REJECTED') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                @if($app->verification_status === 'APPROVED')
                                    DISETUJUI
                                @elseif($app->verification_status === 'REJECTED')
                                    DITOLAK
                                @else
                                    {{ $app->verification_status ?? 'MENUNGGU' }}
                                @endif
                            </span>
                        </td>
                        <td class="p-4">
                            {{ $app->supervisor->name ?? '-' }}
                        </td>
                        <td class="p-4">
                            {{ $app->fieldSupervisor->name ?? '-' }}
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $app->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500">Tidak ada pengajuan ditemukan.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
