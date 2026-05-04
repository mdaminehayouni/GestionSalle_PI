@extends('layouts.etudiant')

@section('content')

<h1 class="text-2xl font-bold mb-6 text-gray-800">Dashboard</h1>

{{-- PROCHAIN COURS --}}
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">

    <h2 class="font-semibold text-gray-700 mb-4">Prochain cours</h2>

    @if(isset($prochainCours) && $prochainCours)

        <div class="flex items-center gap-4">

            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                📘
            </div>

            <div>
                <p class="font-bold text-gray-800">
                    {{ $prochainCours->matiere }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $prochainCours->date }}
                    • {{ $prochainCours->heure_deb }} - {{ $prochainCours->heure_fin }}
                </p>
            </div>

        </div>

    @else
        <p class="text-gray-500">Aucun cours à venir</p>
    @endif

</div>

{{-- STATS --}}
<div class="grid grid-cols-3 gap-4">

    <div class="bg-white p-5 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm">Cours</p>
        <p class="text-2xl font-bold text-gray-800">{{ $nbCours ?? 0 }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm">Heures</p>
        <p class="text-2xl font-bold text-gray-800">{{ $heures ?? 0 }}h</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm">Rattrapages</p>
        <p class="text-2xl font-bold text-orange-500">{{ $rattrapages ?? 0 }}</p>
    </div>

</div>

@endsection