@extends('layouts.app')

@section('title', 'Review Seminar KP')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Review Pengajuan Seminar KP</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $application->student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->student->nim }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $application->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->statusBadgeClass() }}">
                                        {{ $application->statusText() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ $application->kegiatan_harian_drive_link }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        Kegiatan Harian
                                    </a>
                                    <br>
                                    <a href="{{ $application->bimbingan_kp_drive_link }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        Bimbingan KP
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($application->status === 'PENDING')
                                        <div class="flex space-x-2">
                                            <button onclick="openApproveModal({{ $application->id }})"
                                                    class="text-green-600 hover:text-green-900">
                                                Setujui
                                            </button>
                                            <button onclick="openRejectModal({{ $application->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada pengajuan seminar yang perlu direview
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pengajuan Seminar</h3>
            <form id="approveForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="examiner_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Dosen Penguji <span class="text-red-500">*</span>
                    </label>
                    <select name="examiner_id" id="examiner_id" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Dosen Penguji</option>
                        @foreach($examiners as $examiner)
                            <option value="{{ $examiner->id }}">{{ $examiner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pengajuan Seminar</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="admin_note" id="admin_note" rows="4" required
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Berikan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApproveModal(applicationId) {
    document.getElementById('approveForm').action = `/admin-prodi/seminar-applications/${applicationId}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveForm').reset();
}

function openRejectModal(applicationId) {
    document.getElementById('rejectForm').action = `/admin-prodi/seminar-applications/${applicationId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}
</script>
@endsection
