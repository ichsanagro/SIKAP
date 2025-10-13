@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
            <p class="text-gray-600 mt-2">Update user information</p>
        </div>
        <a href="{{ route('super-admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ← Back to Users
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('super-admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Role</option>
                        <option value="MAHASISWA" {{ old('role', $user->role) == 'MAHASISWA' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="ADMIN_PRODI" {{ old('role', $user->role) == 'ADMIN_PRODI' ? 'selected' : '' }}>Admin Prodi</option>
                        <option value="DOSEN_SUPERVISOR" {{ old('role', $user->role) == 'DOSEN_SUPERVISOR' ? 'selected' : '' }}>Dosen Supervisor</option>
                        <option value="PENGAWAS_LAPANGAN" {{ old('role', $user->role) == 'PENGAWAS_LAPANGAN' ? 'selected' : '' }}>Pengawas Lapangan</option>
                        <option value="SUPERADMIN" {{ old('role', $user->role) == 'SUPERADMIN' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $user->nim) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prodi -->
                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="prodi" id="prodi" value="{{ old('prodi', $user->prodi) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('prodi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supervisor (only for MAHASISWA) -->
                <div id="supervisor-field" style="display: {{ $user->role == 'MAHASISWA' ? 'block' : 'none' }};">
                    <label for="supervisor_id" class="block text-sm font-medium text-gray-700">Dosen Pembimbing</label>
                    <select name="supervisor_id" id="supervisor_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Dosen Pembimbing</option>
                        @foreach(\App\Models\User::where('role', 'DOSEN_SUPERVISOR')->get() as $supervisor)
                            <option value="{{ $supervisor->id }}" {{ old('supervisor_id', $user->supervisor_id) == $supervisor->id ? 'selected' : '' }}>
                                {{ $supervisor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('super-admin.users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition mr-3">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('role').addEventListener('change', function() {
    const supervisorField = document.getElementById('supervisor-field');
    if (this.value === 'MAHASISWA') {
        supervisorField.style.display = 'block';
    } else {
        supervisorField.style.display = 'none';
    }
});
</script>
@endsection
