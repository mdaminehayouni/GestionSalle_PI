@extends('layouts.enseignant')
@section('page-title', 'Tableau de bord')

<link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@section('content')

{{-- STATS GRID --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

    {{-- CARD 1 --}}
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-3 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div class="w-11 h-11 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-600">
                Maintenant
            </span>
        </div>

        <div class="text-3xl font-bold">
            {{ $sallesDisponibles ?? 24 }}
        </div>
        <div class="text-sm text-gray-500">
            Salles disponibles
        </div>
    </div>

    {{-- CARD 2 --}}
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-3 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
            </div>
        </div>

        <div class="text-3xl font-bold">
            {{ $mesReservations ?? 8 }}
        </div>
        <div class="text-sm text-gray-500">
            Mes réservations
        </div>
    </div>

    {{-- CARD 3 --}}
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-3 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div class="w-11 h-11 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                <i class="fa-solid fa-clock"></i>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-orange-100 text-orange-600">
                En attente
            </span>
        </div>

        <div class="text-3xl font-bold">
            {{ $demandesEnCours ?? 3 }}
        </div>
        <div class="text-sm text-gray-500">
            Demandes en cours
        </div>
    </div>

    {{-- CARD 4 --}}
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-3 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div class="w-11 h-11 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-lg">send</span>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 text-purple-600">
                Ce mois
            </span>
        </div>

        <div class="text-3xl font-bold">
            {{ $reclamationsEnvoyees ?? 2 }}
        </div>
        <div class="text-sm text-gray-500">
            Réclamations envoyées
        </div>
    </div>

</div>

{{-- BOTTOM GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- RESERVATIONS --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <span class="material-symbols-outlined">calendar_month</span>
                Mes réservations
            </h2>

            <a href="{{ route('enseignant.reservations') }}"
               class="text-blue-600 text-sm font-semibold hover:underline">
                Voir tout
            </a>
        </div>

        <div class="space-y-3">

            @forelse($reservationsRecentes ?? [] as $r)

                <div class="flex items-center gap-4 p-3 border rounded-xl hover:shadow transition">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-bold bg-blue-100 text-blue-700">
                        {{ strtoupper(substr($r->matiere ?? 'RS', 0, 2)) }}
                    </div>

                    <div class="flex-1">
                        <div class="font-semibold text-sm">
                            {{ $r->salle->nomSalle ?? '' }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ $r->date }} | {{ substr($r->heure_deb, 0, 5) }} - {{ substr($r->heure_fin, 0, 5) }}
                        </div>

                        <div class="text-xs text-gray-400">
                            {{ $r->matiere }}
                        </div>
                    </div>

                    <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-600 font-semibold">
                        Réservée
                    </span>

                </div>

            @empty

                <div class="text-sm text-gray-500">
                    Aucune réservation à venir
                </div>

            @endforelse

        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-lg font-bold mb-5 flex items-center gap-2">
            <span class="material-symbols-outlined">bolt</span>
            Actions
        </h2>

        <div class="space-y-3">

            <a href="{{ route('enseignant.reservations') }}"
               class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:shadow transition">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                Réserver une salle
            </a>

            <a href="{{ route('enseignant.reclamations') }}"
               class="flex items-center gap-3 p-4 rounded-xl bg-purple-50 text-purple-700 font-semibold hover:shadow transition">
                <div class="w-10 h-10 bg-purple-600 text-white rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined">send</span>
                </div>
                Envoyer réclamation
            </a>

            <a href="{{ route('enseignant.messages') }}"
               class="flex items-center gap-3 p-4 rounded-xl bg-green-50 text-green-700 font-semibold hover:shadow transition">
                <div class="w-10 h-10 bg-green-600 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                Messages étudiants
            </a>

        </div>

    </div>

</div>

@endsection