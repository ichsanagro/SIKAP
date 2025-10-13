@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Activity Logs Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua log aktivitas mahasiswa</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Activity Logs ({{ $logs->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Student</th>
                        <th class="text-left p-4">Date</th>
                        <th class="text-left p-4">Description</th>
                        <th class="text-left p-4">Photo</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $log->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $log->student->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $log->student->nim ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ $log->date ? $log->date->format('d M Y') : '-' }}</td>
                        <td class="p-4">{{ Str::limit($log->description, 40) }}</td>
                        <td class="p-4">
                            @if($log->photo_path)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($log->status === 'APPROVED') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $log->status ?? 'PENDING' }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $log->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">No activity logs found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
