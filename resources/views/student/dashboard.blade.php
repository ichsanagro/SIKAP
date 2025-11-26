@extends('layouts.app')

@section('content')
<div class="space-y-6">
  {{-- Welcome Section --}}
  <div class="bg-gradient-to-r from-unibBlue to-blue-600 text-white rounded-2xl p-6 shadow-lg">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="text-blue-100">Pantau progress Kerja Praktik Anda di sini</p>
      </div>
      <div class="hidden md:block">
        <i class="fas fa-graduation-cap text-4xl opacity-20"></i>
      </div>
    </div>
  </div>

  {{-- Quick Stats --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    {{-- KP Applications Count --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Total Pengajuan KP</p>
          <p class="text-2xl font-bold text-unibBlue">{{ $kpApplications->count() }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
          <i class="fas fa-file-alt text-unibBlue text-xl"></i>
        </div>
      </div>
    </div>

    {{-- Active KP --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">KP Aktif</p>
          <p class="text-2xl font-bold text-green-600">{{ $activeKp ? 1 : 0 }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
          <i class="fas fa-play text-green-600 text-xl"></i>
        </div>
      </div>
    </div>

    {{-- Mentoring Sessions --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Sesi Bimbingan</p>
          <p class="text-2xl font-bold text-purple-600">{{ $recentMentoring->count() }}</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-full">
          <i class="fas fa-comments text-purple-600 text-xl"></i>
        </div>
      </div>
    </div>

    {{-- Activity Logs --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Aktivitas Lapangan</p>
          <p class="text-2xl font-bold text-orange-600">{{ $recentActivities->count() }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
          <i class="fas fa-history text-orange-600 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- Main Content Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- KP Status Overview --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Status Pengajuan KP</h2>
        <a href="{{ route('kp-applications.index') }}" class="text-unibBlue hover:text-blue-700 text-sm font-medium">
          Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>

      @if($kpApplications->count() > 0)
        <div class="space-y-3">
          @foreach($kpApplications->take(3) as $kp)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex-1">
                <p class="font-medium text-gray-800">{{ Str::limit($kp->title, 40) }}</p>
                <p class="text-sm text-gray-600">
                  @if($kp->placement_option === '1') Opsi 1 (Batch 1)
                  @elseif($kp->placement_option === '2') Opsi 2 (Batch 2)
                  @else Mandiri
                  @endif
                </p>
              </div>
              <span class="px-3 py-1 rounded-full text-xs font-medium
                @class([
                  'bg-gray-100 text-gray-700' => $kp->status === 'DRAFT',
                  'bg-yellow-100 text-yellow-800' => $kp->status === 'SUBMITTED',
                  'bg-blue-100 text-blue-800' => $kp->status === 'VERIFIED_PRODI',
                  'bg-green-100 text-green-800' => in_array($kp->status, ['APPROVED','COMPLETED']),
                  'bg-red-100 text-red-800' => $kp->status === 'REJECTED',
                ])
              ">
                {{ $kp->status }}
              </span>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8">
          <i class="fas fa-file-alt text-gray-300 text-3xl mb-3"></i>
          <p class="text-gray-500 mb-4">Belum ada pengajuan KP</p>
          <a href="{{ route('kp-applications.create') }}" class="btn-primary">Ajukan KP Sekarang</a>
        </div>
      @endif
    </div>

    {{-- Recent Mentoring --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Bimbingan Terbaru</h2>
        <a href="{{ route('mentoring-logs.index') }}" class="text-unibBlue hover:text-blue-700 text-sm font-medium">
          Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>

      @if($recentMentoring->count() > 0)
        <div class="space-y-3">
          @foreach($recentMentoring as $mentoring)
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
              <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-comments text-purple-600 text-xs"></i>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800">{{ Str::limit($mentoring->notes, 50) }}</p>
                <p class="text-xs text-gray-500">
                  {{ $mentoring->created_at->format('d M Y, H:i') }}
                  @if($mentoring->supervisor)
                    • {{ $mentoring->supervisor->name }}
                  @endif
                </p>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8">
          <i class="fas fa-comments text-gray-300 text-3xl mb-3"></i>
          <p class="text-gray-500">Belum ada catatan bimbingan</p>
        </div>
      @endif
    </div>

    {{-- Recent Activities --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Aktivitas Lapangan Terbaru</h2>
        <a href="{{ route('activity-logs.index') }}" class="text-unibBlue hover:text-blue-700 text-sm font-medium">
          Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>

      @if($recentActivities->count() > 0)
        <div class="space-y-3">
          @foreach($recentActivities as $activity)
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
              <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-history text-orange-600 text-xs"></i>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800">{{ Str::limit($activity->activity, 50) }}</p>
                <p class="text-xs text-gray-500">
                  {{ $activity->date->format('d M Y') }} • {{ $activity->hours }} jam
                </p>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-8">
          <i class="fas fa-history text-gray-300 text-3xl mb-3"></i>
          <p class="text-gray-500">Belum ada aktivitas lapangan</p>
        </div>
      @endif
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
      <div class="grid grid-cols-2 gap-3">
        @if($kpApplications->whereIn('status', ['APPROVED', 'ASSIGNED_SUPERVISOR', 'COMPLETED'])->count() === 0)
          <a href="{{ route('kp-applications.create') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
            <i class="fas fa-plus text-unibBlue text-xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">Ajukan KP</span>
          </a>
        @else
          <a href="{{ route('mentoring-logs.create') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
            <i class="fas fa-comments text-purple-600 text-xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">Bimbingan</span>
          </a>
        @endif

        <a href="{{ route('activity-logs.create') }}" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors">
          <i class="fas fa-history text-orange-600 text-xl mb-2"></i>
          <span class="text-sm font-medium text-gray-700">Aktivitas</span>
        </a>

        <a href="{{ route('questionnaires.index') }}" class="flex flex-col items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
          <i class="fas fa-clipboard-list text-indigo-600 text-xl mb-2"></i>
          <span class="text-sm font-medium text-gray-700">Kuesioner</span>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
