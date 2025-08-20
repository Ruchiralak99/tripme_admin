{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TripMe Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            primary: {
              50: '#fef3f2',
              100: '#fee4e2',
              200: '#fececa',
              300: '#fda4a5',
              400: '#fb7172',
              500: '#f44647',
              600: '#e12d2f',
              700: '#bc1f21',
              800: '#9c1d1f',
              900: '#831e20',
            }
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 text-slate-800 font-sans antialiased">

  {{-- Mobile top bar --}}
  <header class="lg:hidden sticky top-0 z-50 flex items-center justify-between bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-4 shadow-lg backdrop-blur-lg">
    <div class="flex items-center gap-3 font-bold">
      <div class="flex items-center justify-center h-10 w-10 rounded-xl bg-white text-primary-600 font-extrabold shadow-lg">
        <span class="text-lg">T</span>
      </div>
      <span class="text-lg font-semibold">TripMe Admin</span>
    </div>
    <button id="sidebarToggle" class="flex items-center justify-center h-10 w-10 rounded-lg bg-white/20 hover:bg-white/30 active:bg-white/40 transition-all duration-200">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </header>

  <div class="relative">
    <div class="lg:grid lg:grid-cols-[280px_1fr] min-h-screen">

      {{-- Sidebar --}}
      <aside id="sidebar"
             class="fixed inset-y-0 left-0 z-40 w-80 -translate-x-full lg:translate-x-0 lg:static bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl lg:shadow-none will-change-transform transition-all duration-300 ease-out">
        <div class="h-full flex flex-col">
          {{-- Logo Section --}}
          <div class="hidden lg:flex items-center gap-4 px-6 pt-8 pb-6 border-b border-slate-700/50">
            {{-- <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white font-extrabold shadow-lg">
              <span class="text-xl">T</span>
            </div>
            <div>
              <div class="text-xl font-bold tracking-tight">TripMe</div>
              <div class="text-sm text-slate-400 font-medium">Admin Dashboard</div>
            </div> --}}

            <img src="{{ asset('images/logo.png') }}" class="w-auto h-12" alt="logo">
          </div>

          {{-- Navigation --}}
          <nav class="flex-1 px-4 py-6 space-y-2">
            <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Management</div>

            <a href="{{ route('super_admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl bg-primary-500/10 text-primary-400 border border-primary-500/20 transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-primary-500/20 group-hover:bg-primary-500/30 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
              </div>
              <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('super_admin.user_management') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
              </div>
              <span class="font-medium">User Management</span>
            </a>

            <a href="{{ route('super_admin.packages') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5v.01M15 5v.01"></path>
                </svg>
              </div>
              <span class="font-medium">Package Management</span>
            </a>

            <a href="{{ route('super_admin.aircrafts') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <span class="font-medium">Air Craft Management</span>
            </a>

            <a href="#" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <span class="font-medium">Booking Management</span>
            </a>

            <a href="#" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <span class="font-medium">Extra</span>
            </a>

            <a href="#" class="group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200">
              <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <span class="font-medium">Extra 01</span>
            </a>

            <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8">Account</div>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
              @csrf
              <button type="submit" class="w-full group flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-red-500/10 text-slate-300 hover:text-red-400 transition-all duration-200">
                <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-700/50 group-hover:bg-red-500/20 transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                </div>
                <span class="font-medium">Logout</span>
              </button>
            </form>
          </nav>

          {{-- User Info --}}
          <div class="p-4 border-t border-slate-700/50">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-700/30">
              <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 text-white font-semibold text-sm">
                {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-white truncate">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                <div class="text-xs text-slate-400 truncate">{{ ucfirst(Auth::user()->role) }}</div>
              </div>
            </div>
          </div>
        </div>
      </aside>

      {{-- Main Content --}}
      <main class="flex-1 lg:overflow-hidden mx-5">
        <div id="pageMain" class="min-h-screen opacity-0 translate-y-2 transition-all duration-500 ease-out">
          <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
            @yield('content')
          </div>
        </div>
      </main>
    </div>
  </div>

  {{-- Overlay for mobile sidebar --}}
  <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 opacity-0 pointer-events-none lg:hidden transition-opacity duration-300"></div>

  {{-- JavaScript --}}
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const main = document.getElementById('pageMain');
    const overlay = document.getElementById('sidebarOverlay');

    // Reveal animation for main content
    window.addEventListener('DOMContentLoaded', () => {
      requestAnimationFrame(() => {
        main.classList.remove('opacity-0', 'translate-y-2');
        main.classList.add('opacity-100', 'translate-y-0');
      });
    });

    // Mobile sidebar toggle
    toggle?.addEventListener('click', () => {
      const isHidden = sidebar.classList.contains('-translate-x-full');

      if (isHidden) {
        // Show sidebar
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
      } else {
        // Hide sidebar
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
      }
    });

    // Close sidebar when clicking overlay
    overlay?.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';
    });

    // Close sidebar when window is resized to desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
      }
    });
  </script>
</body>
</html>
