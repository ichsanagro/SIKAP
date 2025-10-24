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

                <!-- Field Supervisor Companies (only for PENGAWAS_LAPANGAN) -->
                <div id="field-supervisor-companies-field" style="display: {{ $user->role == 'PENGAWAS_LAPANGAN' ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Magang yang Dibina</label>
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <p class="text-sm text-gray-600 mb-3">Pilih perusahaan/tempat magang yang akan dibina oleh pengawas lapangan ini:</p>
                        <div class="max-h-60 overflow-y-auto">
                            @php
                                $allCompanies = \App\Models\Company::with(['kpApplications' => function($q) {
                                    $q->whereIn('status', ['APPROVED', 'ONGOING', 'COMPLETED']);
                                }])->get();
                                $assignedCompanyIds = $user->supervisedCompanies->pluck('id')->toArray();
                            @endphp
                            @foreach($allCompanies as $company)
                                @php
                                    $studentCount = $company->kpApplications->count();
                                @endphp
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="supervised_companies[]" value="{{ $company->id }}"
                                           id="company_{{ $company->id }}"
                                           {{ in_array($company->id, $assignedCompanyIds) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="company_{{ $company->id }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $company->name }}
                                        @if($studentCount > 0)
                                            <span class="text-blue-600 font-medium">({{ $studentCount }} mahasiswa)</span>
                                        @else
                                            <span class="text-gray-400">(Belum ada mahasiswa)</span>
                                        @endif
                                        @if($company->address)
                                            <br><span class="text-gray-500 text-xs">{{ $company->address }}</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Centang perusahaan yang akan dibina oleh pengawas lapangan ini. Semua mahasiswa KP di perusahaan tersebut akan otomatis menjadi tanggung jawab pengawas ini.</p>
                    </div>
                    @error('supervised_companies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div id="nim-field" style="display: {{ $user->role == 'MAHASISWA' ? 'block' : 'none' }};">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $user->nim) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nim')
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
    const nimField = document.getElementById('nim-field');
    const supervisorField = document.getElementById('supervisor-field');
    const fieldSupervisorCompaniesField = document.getElementById('field-supervisor-companies-field');

    // Show NIM field only for MAHASISWA
    if (this.value === 'MAHASISWA') {
        nimField.style.display = 'block';
        supervisorField.style.display = 'block';
        fieldSupervisorCompaniesField.style.display = 'none';
    } else if (this.value === 'PENGAWAS_LAPANGAN') {
        nimField.style.display = 'none';
        supervisorField.style.display = 'none';
        fieldSupervisorCompaniesField.style.display = 'block';
    } else if (this.value === 'ADMIN_PRODI' || this.value === 'DOSEN_SUPERVISOR' || this.value === 'SUPERADMIN') {
        nimField.style.display = 'none';
        supervisorField.style.display = 'none';
        fieldSupervisorCompaniesField.style.display = 'none';
    } else {
        nimField.style.display = 'none';
        supervisorField.style.display = 'none';
        fieldSupervisorCompaniesField.style.display = 'none';
    }
});
</script>
@endsection
