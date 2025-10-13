@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reports Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua laporan KP</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Reports ({{ $reports->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Student</th>
                        <th class="text-left p-4">Application</th>
                        <th class="text-left p-4">File</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Grade</th>
                        <th class="text-left p-4">Submitted</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reports as $report)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $report->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $report->student->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $report->student->nim ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ Str::limit($report->kpApplication->title ?? '-', 30) }}</td>
                        <td class="p-4">
                            @if($report->file_path)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($report->status === 'APPROVED') bg-green-100 text-green-800
                                @elseif($report->status === 'REVISION') bg-yellow-100 text-yellow-800
                                @elseif($report->status === 'VERIFIED_PRODI') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $report->status ?? 'SUBMITTED' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $report->grade ?? '-' }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $report->submitted_at ? $report->submitted_at->format('d M Y') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">No reports found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
