<div      class="min-h-full flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 p-4">
<x-guest-layout>
<div id="login-page ">

    <div class="w-full max-w-md fade-in">

        <!-- Logo + Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6">
                <svg class="w-12 h-12 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">
                Université ISET RADES
            </h1>

            <h2 class="text-lg font-medium text-blue-100 mt-4">
                Plateforme de Gestion des Salles
            </h2>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">
                Connexion
            </h3>
            <!-- SESSION ERROR -->
            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('email') 
                        ? '!border-red-500 focus:!ring-red-500' 
                        : '!border-gray-200 focus:!ring-blue-500' }}"
                           placeholder="exemple@univ.ma">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>

                    <input type="password"
                           name="password"
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- REMEMBER + LINKS -->
                <div class="flex items-center justify-between text-sm gap-5">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded">
                        <span class="text-gray-600">Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-blue-600 hover:text-blue-700">
                            Mot de passe oublié ?
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="text-blue-600 hover:text-blue-700">
                            S'inscrire?
                        </a>
                    @endif
                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white font-semibold rounded-xl hover:opacity-90 transition">
                    Se connecter
                </button>

            </form>
        </div>

        <p class="text-center text-blue-200 text-sm mt-6">
            © 2026 Plateforme Universitaire
        </p>

    </div>
</div>

</x-guest-layout>
</div>