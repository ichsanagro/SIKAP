@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Company Quotas Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua kuota perusahaan per periode</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Company Quotas ({{ $quotas->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Company</th>
                        <th class="text-left p-4">Period</th>
                        <th class="text-left p-4">Quota</th>
                        <th class="text-left p-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($quotas as $quota)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $quota->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $quota->company->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $quota->company->address ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ $quota->period }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $quota->quota }} mahasiswa
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $quota->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No quotas found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $quotas->links() }}
        </div>
    </div>
</div>
@endsection
