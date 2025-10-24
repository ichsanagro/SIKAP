<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'SIKAP' }}</title>

  {{-- FontAwesome Icons --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  {{-- Anti-FOUC for Alpine.js --}}
  <style>[x-cloak]{display:none!important}</style>

  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900" x-data="layoutState()">
  {{-- Sidebar --}}
  @auth
    @include('layouts.sidebar')
  @endauth

  {{-- Main Layout --}}
  <div class="min-h-screen flex bg-gray-50">
    {{-- Sidebar Spacer for Desktop --}}
    @auth
      <div class="hidden md:block" :class="sidebarExpanded ? 'w-64' : 'w-20'" x-show="!mobileOpen"></div>
    @endauth

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-x-auto">
      {{-- Top Header --}}
      <header class="bg-[#0a3d91] text-white shadow-sm">
        <div class="flex items-center justify-between px-4 py-4">
          {{-- Mobile Menu Button --}}
          @auth
            <button @click="toggleMobile()" class="md:hidden p-2 text-white hover:bg-blue-700 rounded">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          @else
            <div></div>
          @endauth

          {{-- Logo/Title --}}
          <div class="flex-1 text-center md:text-left">
            <h1 class="text-xl font-bold">SIKAP</h1>
          </div>

          {{-- User Menu --}}
          <div class="flex items-center gap-4">
            @auth
              {{-- Dropdown akun + Logout --}}
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
              <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded transition-colors">Masuk</a>
            @endauth
          </div>
        </div>
      </header>

      {{-- Page Content --}}
      <main class="flex-1 p-4 md:p-6 min-w-0">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
      </main>

      {{-- Footer --}}
      <footer class="border-t bg-white">
        <div class="px-4 py-6 text-sm text-gray-500 text-center">
          &copy; {{ date('Y') }} SIKAP — Universitas Bengkulu, Fakultas Teknik.
        </div>
      </footer>
    </div>
  </div>

  {{-- Mobile Overlay --}}
  @auth
    <div x-show="mobileOpen" @click="closeMobile()" class="fixed inset-0 bg-black/40 md:hidden z-40"></div>
  @endauth

  {{-- Alpine.js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- Alpine.js Layout State --}}
  <script>
    function layoutState(){
      return {
        sidebarExpanded: JSON.parse(localStorage.getItem('sidebar:state') ?? 'true'),
        mobileOpen: false,
        openMobile(){ this.mobileOpen = true; document.body.classList.add('overflow-hidden'); },
        closeMobile(){ this.mobileOpen = false; document.body.classList.remove('overflow-hidden'); },
        toggleMobile(){ this.mobileOpen ? this.closeMobile() : this.openMobile(); },
        toggleDesktop(){
          this.sidebarExpanded = !this.sidebarExpanded;
          localStorage.setItem('sidebar:state', JSON.stringify(this.sidebarExpanded));
        }
      }
    }
  </script>

  @yield('scripts')
</body>
</html>
