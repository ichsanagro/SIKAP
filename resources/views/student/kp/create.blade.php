@extends('layouts.app')

@section('content')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Ajukan Kerja Praktik</h2>

  {{-- Search Bar --}}
  <form method="GET" action="{{ route('kp-applications.create') }}" class="mb-6">
    <div class="flex gap-2">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari instansi tempat kerja praktik..." class="flex-1 border rounded-xl p-3">
      <button type="submit" class="btn-primary">Cari</button>
    </div>
  </form>

  {{-- Company Cards --}}
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @forelse($companies as $company)
      <div class="border rounded-xl p-4 shadow-sm hover:shadow-md transition">
        <h3 class="font-semibold text-lg">{{ $company->name }}</h3>
        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($company->address, 50) }}</p>
        <p class="text-xs text-gray-500">Kuota tersedia: {{ $company->quota }}</p>
        <div class="mt-3">
          <a href="{{ route('kp.company.detail', $company) }}" class="btn-primary text-sm">Info</a>
        </div>
      </div>
    @empty
      <p class="col-span-full text-center text-gray-500 mb-6">Tidak ada instansi ditemukan.</p>
    @endforelse
  </div>

  {{-- Button for Other Company --}}
  <div class="border-t pt-6">
    <p class="text-center text-gray-600 mb-4">Tidak menemukan instansi yang sesuai?</p>
    <div class="text-center">
      <a href="{{ route('kp.apply.other.form') }}" class="btn-orange">Ajukan KP di Instansi Lain</a>
    </div>
  </div>
</div>
@endsection
