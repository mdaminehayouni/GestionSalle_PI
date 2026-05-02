<aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col">

    <!-- HEADER -->
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-sm">UniSalles</h1>
                <p class="text-xs text-amber-200">Administration</p>
            </div>
        </div>
    </div>

    <!-- NAV -->
    <nav class="flex-1 p-4 space-y-1">

        <!-- DASHBOARD -->
        <a href="{{ route('chef.dashboard') }}"
        class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
        {{ request()->routeIs('chef.dashboard') ? 'active' : '' }}">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>

            Tableau de bord
        </a>

        <!-- ENSEIGNANTS -->
        <a href="{{ route('chef.gestionEnseignant') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
           {{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 text-white-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Enseignants
        </a>

        <!-- SALLES -->
        <a href="{{ route('chef.gestionSalle') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7"/>
            </svg>
            Gestion des salles
        </a>
        <a href="{{ route('chef.gestionSeance') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7"/>
            </svg>
            Gestion des Seances
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-300">
                Déconnexion
            </button>
        </form>
    </div>

</aside>