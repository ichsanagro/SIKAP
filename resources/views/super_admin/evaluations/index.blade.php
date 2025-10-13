@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Field Evaluations Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua evaluasi pengawas lapangan</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Field Evaluations ({{ $evaluations->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Student</th>
                        <th class="text-left p-4">Supervisor</th>
                        <th class="text-left p-4">Rating</th>
                        <th class="text-left p-4">Evaluation</th>
                        <th class="text-left p-4">Feedback</th>
                        <th class="text-left p-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($evaluations as $evaluation)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $evaluation->id }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $evaluation->application->student->name ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $evaluation->application->student->nim ?? '-' }}</div>
                        </td>
                        <td class="p-4">{{ $evaluation->supervisor->name ?? '-' }}</td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <span class="font-semibold">{{ $evaluation->rating }}/5</span>
                                <div class="ml-2 flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $evaluation->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td class="p-4">{{ Str::limit($evaluation->evaluation, 40) }}</td>
                        <td class="p-4">{{ Str::limit($evaluation->feedback, 40) }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $evaluation->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">No evaluations found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $evaluations->links() }}
        </div>
    </div>
</div>
@endsection
