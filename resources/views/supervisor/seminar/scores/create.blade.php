<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Nilai Seminar Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('supervisor.seminar.scores.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            @if(isset($selectedApp) && $selectedApp)
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Mahasiswa Terpilih
                                </label>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="text-sm font-medium text-gray-900">{{ $selectedApp->student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $selectedApp->student->nim }}</div>
                                    <div class="text-sm text-gray-600">{{ Str::limit($selectedApp->title, 50) }}</div>
                                    <input type="hidden" name="kp_application_id" value="{{ $selectedApp->id }}">
                                </div>
                            @else
                                <label for="kp_application_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Mahasiswa KP
                                </label>
                                <select name="kp_application_id" id="kp_application_id" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    @foreach($applications as $app)
                                        <option value="{{ $app->id }}">
                                            {{ $app->student->name }} - {{ $app->student->nim }} ({{ Str::limit($app->title, 50) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kp_application_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="laporan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Laporan Kerja Praktik
                                </label>
                                <input type="number" name="laporan" id="laporan" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('laporan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="presentasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Presentasi dan Pemahaman Materi
                                </label>
                                <input type="number" name="presentasi" id="presentasi" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('presentasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sikap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sikap dan Etika
                                </label>
                                <input type="number" name="sikap" id="sikap" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('sikap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                      placeholder="Tambahkan catatan penilaian..."></textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Pratinjau Nilai Akhir</h3>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Total Skor:</span>
                                    <span id="total-score" class="font-medium text-gray-900">0</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Rata-rata:</span>
                                    <span id="average-score" class="font-medium text-gray-900">0.00</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Nilai Huruf:</span>
                                    <span id="grade" class="font-medium text-gray-900">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('supervisor.seminar.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const laporanInput = document.getElementById('laporan');
            const presentasiInput = document.getElementById('presentasi');
            const sikapInput = document.getElementById('sikap');
            const totalScoreSpan = document.getElementById('total-score');
            const averageScoreSpan = document.getElementById('average-score');
            const gradeSpan = document.getElementById('grade');

            function calculateScore() {
                const laporan = parseFloat(laporanInput.value) || 0;
                const presentasi = parseFloat(presentasiInput.value) || 0;
                const sikap = parseFloat(sikapInput.value) || 0;

                const totalScore = laporan + presentasi + sikap;
                const averageScore = (totalScore / 3).toFixed(2);
                totalScoreSpan.textContent = totalScore;
                averageScoreSpan.textContent = averageScore;

                let grade = '-';
                if (averageScore >= 85) grade = 'A';
                else if (averageScore >= 75) grade = 'B';
                else if (averageScore >= 65) grade = 'C';
                else if (averageScore >= 55) grade = 'D';
                else if (averageScore >= 0) grade = 'E';

                gradeSpan.textContent = grade;
            }

            laporanInput.addEventListener('input', calculateScore);
            presentasiInput.addEventListener('input', calculateScore);
            sikapInput.addEventListener('input', calculateScore);
        });
    </script>
</x-app-layout>
