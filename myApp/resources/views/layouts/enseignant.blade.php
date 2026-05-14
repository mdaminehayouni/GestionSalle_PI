<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('page-title') | Enseignant</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            box-sizing: border-box;
        }

        .sidebar-item { transition: all 0.2s ease; }
        .sidebar-item:hover { background: rgba(255,255,255,0.1); }
        .sidebar-item.active {
            background: rgba(255,255,255,0.15);
            border-left: 3px solid #60a5fa;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gradient-to-b from-slate-900 to-blue-900 text-white flex flex-col">

        {{-- LOGO --}}
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-blue-900"></i>
                </div>

                <div>
                    <h1 class="font-bold text-sm">UniSalles</h1>
                    <p class="text-xs text-blue-200">Espace Enseignant</p>
                </div>

            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 p-4 space-y-1">

            <a href="{{ route('enseignant.dashboard') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
               {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('enseignant.reservations') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
               {{ request()->routeIs('enseignant.reservations') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                Mes réservations
            </a>

            <a href="{{ route('enseignant.reclamations') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
               {{ request()->routeIs('enseignant.reclamations') ? 'active' : '' }}">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Réclamations
            </a>

            <a href="{{ route('enseignant.emploie') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
               {{ request()->routeIs('enseignant.emploie') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-week"></i>
                Emploi du temps
            </a>

            <a href="{{ route('enseignant.messages') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
               {{ request()->routeIs('enseignant.messages') ? 'active' : '' }}">
                <i class="fa-solid fa-comments"></i>
                Messages étudiants
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-300">
                        Déconnexion
                    </button>
                </form>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

            <h1 class="text-lg font-bold">
                @yield('page-title')
            </h1>

            <div class="flex items-center gap-3">

                <div class="text-right">
                    <div class="text-sm font-semibold">
                        {{ auth()->user()->name ?? 'Enseignant' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        Enseignant
                    </div>
                </div>

                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'E',0,1)) }}
                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <main class="p-6">

            @yield('content')

        </main>

    </div>

</div>

@stack('scripts')

</body>
</html>