{{-- Sidebar untuk role-based navigation --}}
<aside
  class="hidden md:flex md:flex-col fixed inset-y-0 left-0 bg-[#0a3d91] text-white transition-all duration-200 z-30"
  :class="sidebarExpanded ? 'w-64' : 'w-20'"
>
  {{-- Header Sidebar --}}
  <div class="flex items-center justify-between p-4 font-bold text-lg border-b border-blue-700">
    <span x-show="sidebarExpanded" class="truncate">SIKAP</span>
    <span x-show="!sidebarExpanded" class="text-sm">S</span>
    <button @click="toggleDesktop()" class="text-white hover:bg-blue-700 p-1 rounded">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              :d="sidebarExpanded ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'"></path>
      </svg>
    </button>
  </div>

  {{-- Navigation Menu --}}
  <nav class="flex-1 overflow-y-auto p-2 space-y-6">
    {{-- SUPERADMIN Menu --}}
    @if(auth()->user()->role === 'SUPERADMIN')
      {{-- Data Management --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen Data</h3>
        <a href="{{ route('super-admin.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.index') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-tachometer-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dasbor</span>
        </a>
        <a href="{{ route('super-admin.users.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.users.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-users"></i>
          <span x-show="sidebarExpanded" class="truncate">Pengguna</span>
        </a>
        <a href="{{ route('super-admin.applications.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.applications.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-file-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Pengajuan</span>
        </a>
        <a href="{{ route('super-admin.companies.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.companies.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-building"></i>
          <span x-show="sidebarExpanded" class="truncate">Perusahaan</span>
        </a>
      </div>

      {{-- Activity & Evaluation --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Aktivitas & Evaluasi</h3>
        <a href="{{ route('super-admin.mentoring-logs.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.mentoring-logs.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-comments"></i>
          <span x-show="sidebarExpanded" class="truncate">Log Bimbingan</span>
        </a>
        <a href="{{ route('super-admin.activity-logs.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.activity-logs.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-history"></i>
          <span x-show="sidebarExpanded" class="truncate">Log Aktivitas</span>
        </a>
        <a href="{{ route('super-admin.reports.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.reports.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-chart-bar"></i>
          <span x-show="sidebarExpanded" class="truncate">Laporan</span>
        </a>
      </div>

      {{-- Scoring & Evaluation --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Penilaian & Evaluasi</h3>
        <a href="{{ route('super-admin.scores.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.scores.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-star"></i>
          <span x-show="sidebarExpanded" class="truncate">Nilai KP</span>
        </a>
        <a href="{{ route('super-admin.evaluations.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.evaluations.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-check-circle"></i>
          <span x-show="sidebarExpanded" class="truncate">Evaluasi</span>
        </a>
      </div>

      {{-- Company Management --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen Perusahaan</h3>
        <a href="{{ route('super-admin.quotas.index') }}"
           :class="(sidebarExpanded ? 'sidebar-link' : 'sidebar-link sidebar-link--compact') + ' {{ request()->routeIs('super-admin.quotas.*') ? ' sidebar-link--active' : '' }}'">
          <i class="fas fa-tags"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuota</span>
        </a>
      </div>
    @endif

    {{-- ADMIN_PRODI Menu --}}
    @if(auth()->user()->role === 'ADMIN_PRODI')
      {{-- Management --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen</h3>
        <a href="{{ route('admin-prodi.index') }}" class="sidebar-link">
          <i class="fas fa-tachometer-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dashboard</span>
        </a>
        <a href="{{ route('admin-prodi.assignments') }}" class="sidebar-link">
          <i class="fas fa-user-check"></i>
          <span x-show="sidebarExpanded" class="truncate">Penugasan</span>
        </a>
        <a href="{{ route('admin-prodi.students.index') }}" class="sidebar-link">
          <i class="fas fa-user-graduate"></i>
          <span x-show="sidebarExpanded" class="truncate">Mahasiswa</span>
        </a>
        <a href="{{ route('admin-prodi.field-supervisors.index') }}" class="sidebar-link">
          <i class="fas fa-user-tie"></i>
          <span x-show="sidebarExpanded" class="truncate">Pengawas Lapangan</span>
        </a>
        <a href="{{ route('admin-prodi.companies.index') }}" class="sidebar-link">
          <i class="fas fa-building"></i>
          <span x-show="sidebarExpanded" class="truncate">Perusahaan</span>
        </a>
        <a href="{{ route('admin-prodi.seminar.index') }}" class="sidebar-link">
          <i class="fas fa-graduation-cap"></i>
          <span x-show="sidebarExpanded" class="truncate">Seminar KP</span>
        </a>
        <a href="{{ route('admin-prodi.questionnaires.index') }}" class="sidebar-link">
          <i class="fas fa-clipboard-list"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuesioner</span>
        </a>
        <a href="{{ route('admin-prodi.questionnaire-responses.index') }}" class="sidebar-link">
          <i class="fas fa-poll-h"></i>
          <span x-show="sidebarExpanded" class="truncate">Tanggapan Kuesioner</span>
        </a>
        <a href="{{ route('admin-prodi.recap-scores.index') }}" class="sidebar-link">
          <i class="fas fa-chart-line"></i>
          <span x-show="sidebarExpanded" class="truncate">Rekap Nilai</span>
        </a>
      </div>
    @endif

    {{-- DOSEN_SUPERVISOR Menu --}}
    @if(auth()->user()->role === 'DOSEN_SUPERVISOR')
      {{-- Supervision --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Supervisi</h3>
        <a href="{{ route('supervisor.dashboard') }}" class="sidebar-link">
          <i class="fas fa-tachometer-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dashboard</span>
        </a>
        <a href="{{ route('supervisor.verifications.index') }}" class="sidebar-link">
          <i class="fas fa-check"></i>
          <span x-show="sidebarExpanded" class="truncate">Verifikasi</span>
        </a>
        <a href="{{ route('supervisor.students.index') }}" class="sidebar-link">
          <i class="fas fa-user-graduate"></i>
          <span x-show="sidebarExpanded" class="truncate">Mahasiswa</span>
        </a>
        <a href="{{ route('supervisor.mentoring.index') }}" class="sidebar-link">
          <i class="fas fa-comments"></i>
          <span x-show="sidebarExpanded" class="truncate">Bimbingan</span>
        </a>
        <a href="{{ route('supervisor.scores.index') }}" class="sidebar-link">
          <i class="fas fa-star"></i>
          <span x-show="sidebarExpanded" class="truncate">Penilaian</span>
        </a>
        <a href="{{ route('supervisor.documents.index') }}" class="sidebar-link">
          <i class="fas fa-file-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dokumen</span>
        </a>
        <a href="{{ route('supervisor.questionnaires.index') }}" class="sidebar-link">
          <i class="fas fa-poll"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuesioner</span>
        </a>
        <a href="{{ route('supervisor.seminar.index') }}" class="sidebar-link">
          <i class="fas fa-graduation-cap"></i>
          <span x-show="sidebarExpanded" class="truncate">Seminar KP</span>
        </a>
      </div>
    @endif

    {{-- PENGAWAS_LAPANGAN Menu --}}
    @if(auth()->user()->role === 'PENGAWAS_LAPANGAN')
      {{-- Field Supervision --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Supervisi Lapangan</h3>
        <a href="{{ route('field.dashboard') }}" class="sidebar-link">
          <i class="fas fa-tachometer-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dashboard</span>
        </a>
        <a href="{{ route('field.students.index') }}" class="sidebar-link">
          <i class="fas fa-user-graduate"></i>
          <span x-show="sidebarExpanded" class="truncate">Mahasiswa</span>
        </a>
        <a href="{{ route('field.scores.index') }}" class="sidebar-link">
          <i class="fas fa-star"></i>
          <span x-show="sidebarExpanded" class="truncate">Penilaian</span>
        </a>
        <a href="{{ route('field.evaluations.index') }}" class="sidebar-link">
          <i class="fas fa-check-circle"></i>
          <span x-show="sidebarExpanded" class="truncate">Evaluasi</span>
        </a>
        <a href="{{ route('field.company-quotas.index') }}" class="sidebar-link">
          <i class="fas fa-tags"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuota</span>
        </a>
        <a href="{{ route('field.questionnaires.index') }}" class="sidebar-link">
          <i class="fas fa-poll"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuesioner</span>
        </a>
      </div>
    @endif

    {{-- MAHASISWA Menu --}}
    @if(auth()->user()->role === 'MAHASISWA')
      {{-- Student Activities --}}
      <div class="space-y-2">
        <h3 x-show="sidebarExpanded" class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Aktivitas Mahasiswa</h3>
        <a href="{{ route('dashboard') }}" class="sidebar-link">
          <i class="fas fa-tachometer-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Dashboard</span>
        </a>
        <a href="{{ route('kp-applications.index') }}" class="sidebar-link">
          <i class="fas fa-file-alt"></i>
          <span x-show="sidebarExpanded" class="truncate">Pengajuan KP</span>
        </a>
        <a href="{{ route('mentoring-logs.index') }}" class="sidebar-link">
          <i class="fas fa-comments"></i>
          <span x-show="sidebarExpanded" class="truncate">Bimbingan</span>
        </a>
        <a href="{{ route('activity-logs.index') }}" class="sidebar-link">
          <i class="fas fa-history"></i>
          <span x-show="sidebarExpanded" class="truncate">Aktivitas</span>
        </a>
        <a href="{{ route('questionnaires.index') }}" class="sidebar-link">
          <i class="fas fa-poll"></i>
          <span x-show="sidebarExpanded" class="truncate">Kuesioner</span>
        </a>
        <a href="{{ route('seminar.index') }}" class="sidebar-link">
          <i class="fas fa-graduation-cap"></i>
          <span x-show="sidebarExpanded" class="truncate">Seminar KP</span>
        </a>
      </div>
    @endif
  </nav>

  {{-- Footer Sidebar --}}
  <div class="p-3 border-t border-blue-700">
    <div class="flex items-center justify-between">
      <div x-show="sidebarExpanded" class="text-xs text-blue-200 truncate">
        {{ auth()->user()->name }}
      </div>
      <form method="POST" action="{{ route('logout') }}" class="flex items-center">
        @csrf
        <button type="submit" class="text-white hover:bg-blue-700 p-2 rounded transition-colors" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </div>
</aside>

{{-- Mobile Drawer --}}
<aside
  class="md:hidden fixed inset-y-0 left-0 w-64 bg-[#0a3d91] text-white z-50 transform transition-transform duration-200"
  :class="mobileOpen ? 'translate-x-0' : '-translate-x-full'"
>
  {{-- Header Mobile Drawer --}}
  <div class="flex items-center justify-between p-4 font-bold text-lg border-b border-blue-700">
    <span>SIKAP</span>
    <button @click="closeMobile()" class="text-white hover:bg-blue-700 p-1 rounded">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>

  {{-- Navigation Menu Mobile --}}
  <nav class="flex-1 overflow-y-auto p-2 space-y-6">
    {{-- SUPERADMIN Menu --}}
    @if(auth()->user()->role === 'SUPERADMIN')
      {{-- Data Management --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen Data</h3>
        <a href="{{ route('super-admin.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dasbor</span>
        </a>
        <a href="{{ route('super-admin.users.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-users"></i>
          <span>Pengguna</span>
        </a>
        <a href="{{ route('super-admin.applications.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-file-alt"></i>
          <span>Pengajuan</span>
        </a>
        <a href="{{ route('super-admin.companies.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-building"></i>
          <span>Perusahaan</span>
        </a>
      </div>

      {{-- Activity & Evaluation --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Aktivitas & Evaluasi</h3>
        <a href="{{ route('super-admin.mentoring-logs.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-comments"></i>
          <span>Log Bimbingan</span>
        </a>
        <a href="{{ route('super-admin.activity-logs.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-history"></i>
          <span>Log Aktivitas</span>
        </a>
        <a href="{{ route('super-admin.reports.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-chart-bar"></i>
          <span>Laporan</span>
        </a>
      </div>

      {{-- Scoring & Evaluation --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Penilaian & Evaluasi</h3>
        <a href="{{ route('super-admin.scores.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-star"></i>
          <span>Nilai KP</span>
        </a>
        <a href="{{ route('super-admin.evaluations.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-check-circle"></i>
          <span>Evaluasi</span>
        </a>
      </div>

      {{-- Company Management --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen Perusahaan</h3>
        <a href="{{ route('super-admin.quotas.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tags"></i>
          <span>Kuota</span>
        </a>
      </div>
    @endif

    {{-- ADMIN_PRODI Menu --}}
    @if(auth()->user()->role === 'ADMIN_PRODI')
      {{-- Management --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Manajemen</h3>
        <a href="{{ route('admin-prodi.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin-prodi.assignments') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-user-check"></i>
          <span>Penugasan</span>
        </a>
        <a href="{{ route('admin-prodi.students.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-user-graduate"></i>
          <span>Mahasiswa</span>
        </a>
        <a href="{{ route('admin-prodi.companies.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-building"></i>
          <span>Perusahaan</span>
        </a>
        <a href="{{ route('admin-prodi.questionnaires.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-clipboard-list"></i>
          <span>Kuesioner</span>
        </a>
        <a href="{{ route('admin-prodi.questionnaire-responses.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-poll-h"></i>
          <span>Tanggapan Kuesioner</span>
        </a>
        <a href="{{ route('admin-prodi.recap-scores.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-chart-line"></i>
          <span>Rekap Nilai</span>
        </a>
      </div>
    @endif

    {{-- DOSEN_SUPERVISOR Menu --}}
    @if(auth()->user()->role === 'DOSEN_SUPERVISOR')
      {{-- Supervision --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Supervisi</h3>
        <a href="{{ route('supervisor.dashboard') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('supervisor.verifications.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-check"></i>
          <span>Verifikasi</span>
        </a>
        <a href="{{ route('supervisor.students.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-user-graduate"></i>
          <span>Mahasiswa</span>
        </a>
        <a href="{{ route('supervisor.mentoring.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-comments"></i>
          <span>Bimbingan</span>
        </a>
        <a href="{{ route('supervisor.scores.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-star"></i>
          <span>Penilaian</span>
        </a>
        <a href="{{ route('supervisor.documents.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-file-alt"></i>
          <span>Dokumen</span>
        </a>
        <a href="{{ route('supervisor.questionnaires.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-poll"></i>
          <span>Kuesioner</span>
        </a>
      </div>
    @endif

    {{-- PENGAWAS_LAPANGAN Menu --}}
    @if(auth()->user()->role === 'PENGAWAS_LAPANGAN')
      {{-- Field Supervision --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Supervisi Lapangan</h3>
        <a href="{{ route('field.dashboard') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('field.students.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-user-graduate"></i>
          <span>Mahasiswa</span>
        </a>
        <a href="{{ route('field.scores.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-star"></i>
          <span>Penilaian</span>
        </a>
        <a href="{{ route('field.evaluations.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-check-circle"></i>
          <span>Evaluasi</span>
        </a>
        <a href="{{ route('field.company-quotas.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tags"></i>
          <span>Kuota</span>
        </a>
        <a href="{{ route('field.questionnaires.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-poll"></i>
          <span>Kuesioner</span>
        </a>
      </div>
    @endif

    {{-- MAHASISWA Menu --}}
    @if(auth()->user()->role === 'MAHASISWA')
      {{-- Student Activities --}}
      <div class="space-y-2">
        <h3 class="text-[11px] uppercase tracking-wider text-white/70 px-3 py-1">Aktivitas Mahasiswa</h3>
        <a href="{{ route('dashboard') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('kp-applications.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-file-alt"></i>
          <span>Pengajuan KP</span>
        </a>
        <a href="{{ route('mentoring-logs.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-comments"></i>
          <span>Bimbingan</span>
        </a>
        <a href="{{ route('activity-logs.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-history"></i>
          <span>Aktivitas</span>
        </a>
        @if(auth()->user()->kpApplications->count() > 0)
        <a href="{{ route('questionnaire.create', ['kp' => auth()->user()->kpApplications->first()->id]) }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-clipboard-list"></i>
          <span>Kuesioner KP</span>
        </a>
        <a href="{{ route('supervisor.questionnaires.index') }}" class="sidebar-link" @click="closeMobile()">
          <i class="fas fa-poll"></i>
          <span>Kuesioner</span>
        </a>
        @endif
      </div>
    @endif
  </nav>

  {{-- Footer Mobile Drawer --}}
  <div class="p-3 border-t border-blue-700">
    <div class="flex items-center justify-between">
      <div class="text-xs text-blue-200 truncate">
        {{ auth()->user()->name }}
      </div>
      <form method="POST" action="{{ route('logout') }}" class="flex items-center">
        @csrf
        <button type="submit" class="text-white hover:bg-blue-700 p-2 rounded transition-colors" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </div>
</aside>

{{-- Custom CSS for sidebar links --}}
<style>
  .sidebar-link {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .5rem .75rem;
    margin: 0 .5rem;
    border-radius: .5rem;
    transition: background-color .2s ease;
  }
  .sidebar-link:hover {
    background-color: rgba(255, 255, 255, .10);
  }
  .sidebar-link--compact {
    flex-direction: column;
    gap: .25rem;
    padding: .5rem .5rem;
    text-align: center;
  }
  .sidebar-link--active {
    background-color: rgba(255, 255, 255, .15);
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .12);
  }
</style>
