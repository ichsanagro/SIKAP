@extends('layouts.app')

@section('content')
@include('student.partials.nav')

<div class="card">
  <h2 class="text-2xl font-bold text-unibBlue mb-4">Detail Instansi</h2>

  <div class="mb-6">
    <h3 class="text-xl font-semibold">{{ $company->name }}</h3>
    <p class="text-gray-600 mt-2">{{ $company->address }}</p>
    <p class="text-sm text-gray-500 mt-1">Kontak: {{ $company->contact_person }} - {{ $company->contact_phone }}</p>
    <p class="text-sm text-gray-500">Kuota tersedia: {{ $company->quota }}</p>
  </div>

  <div class="text-center">
    <a href="{{ route('kp.apply.form', $company) }}" class="btn-primary">Ajukan KP</a>
  </div>
</div>
@endsection
