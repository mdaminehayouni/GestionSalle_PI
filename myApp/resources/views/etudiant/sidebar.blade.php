<aside class="w-64 min-h-screen flex-shrink-0 bg-gradient-to-b from-emerald-800 to-emerald-900 text-white flex flex-col justify-between">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=calendar_today" />    
<style>
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 200,
  'GRAD' 0,
  'opsz' 24
}
</style>
{{-- HEADER --}}

    <div>

        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-800" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-sm">UniSalles</h2>
                    <p class="text-xs text-emerald-200">Espace Étudiant</p>
                </div>

            </div>
        </div>

        {{-- NAV --}}
        <nav class="p-4 space-y-2">

            <a href="{{ route('etudiant.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm sidebar-item {{ request()->routeIs('etudiant.dashboard')?'active' : ''  }}">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('etudiant.emploie') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm sidebar-item {{ request()->routeIs('etudiant.emploie')?'active' : ''  }}">
                <span class="material-symbols-outlined">
                    calendar_today
                </span>
                Emploi du temps
            </a>

            <a href="{{ route('etudiant.messages') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm sidebar-item">
                Messages
            </a>

        </nav>

    </div>

    {{-- LOGOUT --}}
    <div class="p-4 border-t border-white/10">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-300 hover:bg-red-500/20 transition">
                Déconnexion
            </button>

        </form>

    </div>

</aside>