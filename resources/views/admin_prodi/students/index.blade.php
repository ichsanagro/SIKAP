@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Mahasiswa</h1>
            <p class="text-gray-600 mt-2">Kelola semua akun mahasiswa</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin-prodi.students.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Mahasiswa
            </a>
            <a href="{{ route('admin-prodi.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Kembali ke Dashboard
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
            <h2 class="text-lg font-semibold">Daftar Mahasiswa ({{ $students->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">NIM</th>

                        <th class="text-left p-4">Dosen Pembimbing</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Pengajuan KP</th>
                        <th class="text-left p-4">Dibuat</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $student->id }}</td>
                        <td class="p-4 font-medium">{{ $student->name }}</td>
                        <td class="p-4">{{ $student->email }}</td>
                        <td class="p-4">{{ $student->nim }}</td>

                        <td class="p-4">
                            @if($student->supervisor)
                                {{ $student->supervisor->name }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $student->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $student->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $student->kpApplications->count() }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $student->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin-prodi.students.edit', $student) }}"
                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                    Ubah
                                </a>
                                <form action="{{ route('admin-prodi.students.toggle-active', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="px-3 py-1 {{ $student->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white text-sm rounded transition">
                                        {{ $student->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin-prodi.students.destroy', $student) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini secara permanen? Data akan hilang dari database.')">
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
                        <td colspan="9" class="p-8 text-center text-gray-500">Belum ada mahasiswa terdaftar.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
