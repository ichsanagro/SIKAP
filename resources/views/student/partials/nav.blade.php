@php
  $isActive = fn($pattern) => request()->is($pattern) ? 'text-unibBlue font-semibold' : 'text-gray-600';
@endphp

<nav class="mb-6 border-b bg-white rounded-2xl p-4 shadow-sm">
  <ul class="flex flex-wrap gap-4">
    <li>
      <a href="{{ route('kp-applications.index') }}" class="{{ $isActive('kp-applications*') }}">Pengajuan KP</a>
    </li>
    <li>
      <a href="{{ route('mentoring-logs.index') }}" class="{{ $isActive('mentoring-logs*') }}">Bimbingan</a>
    </li>
    <li>
      <a href="{{ route('activity-logs.index') }}" class="{{ $isActive('activity-logs*') }}">Aktivitas Lapangan</a>
    </li>
  </ul>
</nav>
