<aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col fixed left-0 top-0 h-full z-10">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 200,
  'GRAD' 0,
  'opsz' 24
}
</style>
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
        <a href="{{ route('enseignant.dashboard') }}"
        class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm
        {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>

            Tableau de bord
        </a>
        <a href="{{ route('enseignant.emploie') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <span class="material-symbols-outlined">
                calendar_today
            </span>
            Emploi du temps
        </a>
        <a href="{{ route('enseignant.salles') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <span class="material-symbols-outlined">
                calendar_today
            </span>
            Salles
        </a>
        <a href="{{ route('enseignant.reservations') }}"
            class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <i class="fa-solid fa-bookmark"></i>
            Réservations
        </a>
        <a href="{{ route('enseignant.reclamations') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <span class="material-symbols-outlined">
                warning
            </span>
            Reclamation
        </a>
        <a href="{{ route('enseignant.messages') }}"
           class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
            <span class="material-symbols-outlined">
                warning
            </span>
            Messages
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