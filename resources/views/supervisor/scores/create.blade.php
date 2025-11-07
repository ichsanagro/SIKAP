<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Nilai Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('supervisor.scores.store') }}" method="POST">
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
                                <label for="report" class="block text-sm font-medium text-gray-700 mb-2">
                                    Laporan Kerja Praktek
                                </label>
                                <input type="number" name="report" id="report" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('report')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="presentation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Presentasi dan Pemahaman Materi
                                </label>
                                <input type="number" name="presentation" id="presentation" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('presentation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="attitude" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sikap dan Etika
                                </label>
                                <input type="number" name="attitude" id="attitude" min="0" max="100" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="0-100">
                                @error('attitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                      placeholder="Tambahkan catatan penilaian..."></textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Pratinjau Nilai Akhir</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Nilai Akhir:</span>
                                    <span id="final-score" class="font-medium text-gray-900">0.00</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Grade:</span>
                                    <span id="final-grade" class="font-medium text-gray-900">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('supervisor.scores.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportInput = document.getElementById('report');
            const presentationInput = document.getElementById('presentation');
            const attitudeInput = document.getElementById('attitude');
            const finalScoreSpan = document.getElementById('final-score');
            const finalGradeSpan = document.getElementById('final-grade');

            function calculateScore() {
                const report = parseFloat(reportInput.value) || 0;
                const presentation = parseFloat(presentationInput.value) || 0;
                const attitude = parseFloat(attitudeInput.value) || 0;

                const finalScore = ((report + presentation + attitude) / 3).toFixed(2);
                finalScoreSpan.textContent = finalScore;

                let grade = '-';
                if (finalScore >= 85) grade = 'A';
                else if (finalScore >= 75) grade = 'B';
                else if (finalScore >= 65) grade = 'C';
                else if (finalScore >= 55) grade = 'D';
                else if (finalScore >= 0) grade = 'E';

                finalGradeSpan.textContent = grade;
            }

            reportInput.addEventListener('input', calculateScore);
            presentationInput.addEventListener('input', calculateScore);
            attitudeInput.addEventListener('input', calculateScore);
        });
    </script>
</x-app-layout>
