@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Users Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua pengguna sistem</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('super-admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Add New User
            </a>
            <a href="{{ route('super-admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">All Users ({{ $users->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Name</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">Role</th>
                        <th class="text-left p-4">NIM</th>
                        <th class="text-left p-4">Prodi</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Applications</th>
                        <th class="text-left p-4">Created</th>
                        <th class="text-left p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $user->id }}</td>
                        <td class="p-4 font-medium">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($user->role === 'SUPERADMIN') bg-red-100 text-red-800
                                @elseif($user->role === 'ADMIN_PRODI') bg-blue-100 text-blue-800
                                @elseif($user->role === 'DOSEN_SUPERVISOR') bg-green-100 text-green-800
                                @elseif($user->role === 'PENGAWAS_LAPANGAN') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-4">{{ $user->nim ?? '-' }}</td>
                        <td class="p-4">{{ $user->prodi ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $user->kpApplications->count() }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('super-admin.users.edit', $user) }}"
                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                    Edit
                                </a>
                                <form action="{{ route('super-admin.users.toggle-active', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="px-3 py-1 {{ $user->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white text-sm rounded transition">
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen? Data akan hilang dari database.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-8 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
