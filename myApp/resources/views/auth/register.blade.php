<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 p-4">
    @php
        $inputClass = "w-full px-4 py-3 border rounded-xl outline-none transition";
    @endphp
    <div class="w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6">
                <svg class="w-12 h-12 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">
                Rejoignez-nous
            </h1>

            <p class="text-blue-200">
                Créez votre compte pour accéder à la plateforme
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">
                Inscription
            </h3>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nom" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required placeholder="Mohamed Amine Hayouni" value="{{ old('name') }}"/>
                </div>

                <!-- Email -->
                <div>
                <x-input-label for="email" value="Email" />

                <x-text-input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="block mt-1 w-full border 
                {{ $errors->has('email') 
                    ? '!border-red-500 focus:!ring-red-500' 
                    : '!border-gray-200 focus:!ring-blue-500' }}" placeholder="mdamine.hayouni@gmail.com"/>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required placeholder="••••••••" value="{{ old('password') }}"/>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

                <!-- Confirm -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirmation" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required placeholder="••••••••" value="{{ old('password_confirmation') }}"/>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
                <!-- Button -->
                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white font-semibold rounded-xl hover:opacity-90 transition">
                    Créer mon compte
                </button>

                <!-- Login link -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium">
                        Se connecter
                    </a>
                </p>

            </form>
        </div>

        <p class="text-center text-blue-200 text-sm mt-6">
            © 2026 Plateforme Universitaire
        </p>

    </div>
</div>
</x-guest-layout>