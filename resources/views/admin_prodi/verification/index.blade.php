@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Verifikasi Pengajuan KP</h1>
        <form method="GET" class="flex gap-2">
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                <option value="PENDING"  @selected(request('status')==='PENDING')>PENDING</option>
                <option value="APPROVED" @selected(request('status')==='APPROVED')>APPROVED</option>
                <option value="REJECTED" @selected(request('status')==='REJECTED')>REJECTED</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Filter</button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Mahasiswa</th>
                    <th class="text-left p-3">Perusahaan</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Terverifikasi</th>
                    <th class="text-left p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($apps as $app)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $app->student->name ?? '-' }}
                        <div class="text-xs text-gray-500">{{ $app->student->email ?? '' }}</div>
                    </td>
                    <td class="p-3">
                        @if($app->company)
                            {{ $app->company->name }}
                        @else
                            {{ $app->custom_company_name ?? '-' }}
                        @endif
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            @if($app->verification_status==='APPROVED') bg-green-100 text-green-700
                            @elseif($app->verification_status==='REJECTED') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $app->verification_status }}
                        </span>
                    </td>
                    <td class="p-3 text-sm">
                        @if($app->verified_at)
                            {{ $app->verified_at->format('d M Y H:i') }}<br>
                            <span class="text-gray-500">oleh {{ $app->verifier->name ?? '-' }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-3">
                        <a href="{{ route('admin-prodi.verifications.show',$app) }}"
                           class="px-3 py-2 bg-indigo-600 text-white rounded">Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-gray-500">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $apps->withQueryString()->links() }}
    </div>
</div>
@endsection
