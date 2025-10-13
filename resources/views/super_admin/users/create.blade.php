@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
            <p class="text-gray-600 mt-2">Add a new user to the system</p>
        </div>
        <a href="{{ route('super-admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Users
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('super-admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Role</option>
                        <option value="MAHASISWA" {{ old('role') == 'MAHASISWA' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="ADMIN_PRODI" {{ old('role') == 'ADMIN_PRODI' ? 'selected' : '' }}>Admin Prodi</option>
                        <option value="DOSEN_SUPERVISOR" {{ old('role') == 'DOSEN_SUPERVISOR' ? 'selected' : '' }}>Dosen Supervisor</option>
                        <option value="PENGAWAS_LAPANGAN" {{ old('role') == 'PENGAWAS_LAPANGAN' ? 'selected' : '' }}>Pengawas Lapangan</option>
                        <option value="SUPERADMIN" {{ old('role') == 'SUPERADMIN' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prodi -->
                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('prodi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('super-admin.users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition mr-3">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
