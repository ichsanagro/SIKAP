@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Companies Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua perusahaan</p>
        </div>
        <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Companies ({{ $companies->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Name</th>
                        <th class="text-left p-4">Address</th>
                        <th class="text-left p-4">Batch</th>
                        <th class="text-left p-4">Quota</th>
                        <th class="text-left p-4">Contact Person</th>
                        <th class="text-left p-4">Phone</th>
                        <th class="text-left p-4">Applications</th>
                        <th class="text-left p-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($companies as $company)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $company->id }}</td>
                        <td class="p-4 font-medium">{{ $company->name }}</td>
                        <td class="p-4">{{ $company->address }}</td>
                        <td class="p-4">{{ $company->batch }}</td>
                        <td class="p-4">{{ $company->quota }}</td>
                        <td class="p-4">{{ $company->contact_person ?? '-' }}</td>
                        <td class="p-4">{{ $company->contact_phone ?? '-' }}</td>
                        <td class="p-4">{{ $company->kpApplications->count() }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $company->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-500">No companies found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $companies->links() }}
        </div>
    </div>
</div>
@endsection
