<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'SIKAP' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
  <header class="bg-unibBlue text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('landing') }}" class="font-bold text-xl">SIKAP</a>

      <nav class="flex items-center gap-4">
        <a href="{{ route('landing') }}" class="hover:underline">Beranda</a>

        @auth
          <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>

          {{-- Dropdown akun + Logout (tanpa JS, pakai <details>) --}}
           <details class="relative z-50">
            <summary class="list-none cursor-pointer flex items-center gap-2">
              <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
              </div>
              <span class="hidden md:inline">{{ auth()->user()->name }}</span>
            </summary>

            <div class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-xl shadow-lg overflow-hidden">
              <div class="px-4 py-2 text-xs text-gray-500">
                {{ auth()->user()->role ?? 'User' }}
              </div>
              <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                Profil / Dashboard
              </a>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                  Keluar
                </button>
              </form>
            </div>
          </details>
        @else
          <a href="{{ route('login') }}" class="btn-orange">Masuk</a>
        @endauth
      </nav>
    </div>
  </header>

  <main class="py-8">
    <div class="max-w-6xl mx-auto px-4">
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
      @endif

      {{ $slot ?? '' }}
      @yield('content')
    </div>
  </main>

  <footer class="border-t bg-white">
    <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-gray-500">
      &copy; {{ date('Y') }} SIKAP — Universitas Bengkulu, Fakultas Teknik.
    </div>
  </footer>
</body>
</html>
