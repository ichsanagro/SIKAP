@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">KP Scores Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua nilai KP</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All KP Scores ({{ $scores->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Student</th>
                        <th class="text-left p-4">Supervisor</th>
                        <th class="text-left p-4">Discipline</th>
                        <th class="text-left p-4">Skill</th>
                        <th class="text-left p-4">Attitude</th>
                        <th class="text-left p-4">Report</th>
                        <th class="text-left p-4">Final Score</th>
                        <th class="text-left p-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($scores as $score)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $score->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $score->application->student->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $score->application->student->nim ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ $score->supervisor->name ?? '-' }}</td>
                        <td class="p-4">{{ $score->discipline }}/100</td>
                        <td class="p-4">{{ $score->skill }}/100</td>
                        <td class="p-4">{{ $score->attitude }}/100</td>
                        <td class="p-4">{{ $score->report }}/100</td>
                        <td class="p-4 font-semibold">{{ $score->final_score }}/100</td>
                        <td class="p-4 text-sm text-gray-600">{{ $score->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-500">No scores found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $scores->links() }}
        </div>
    </div>
</div>
@endsection
