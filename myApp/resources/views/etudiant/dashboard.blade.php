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
<div class="grid grid-cols-2 gap-4">

    <div class="bg-white p-5 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm">Cours</p>
        <p class="text-2xl font-bold text-gray-800">{{ $nbCours ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <p class="text-gray-500 text-sm">Messages</p>
            <p class="text-2xl font-bold text-black-600">{{ count($messages ?? []) }}</p>
    </div>
</div>
{{-- MESSAGES --}}
<div class="mt-6 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">

    <h2 class="font-semibold text-gray-700 mb-4">Messages récents</h2>

    <div class="space-y-4">

        @forelse($messages as $m)

            <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 hover:bg-white hover:shadow-sm transition">

                {{-- TOP --}}
                <div class="flex justify-between items-start mb-2">

                    <div class="flex items-center gap-2">

                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold">
                            {{ substr($m->enseignant->prenom ?? 'P', 0, 1) }}
                        </div>

                        <div class="font-semibold text-gray-800 text-sm">
                            {{ $m->enseignant->nom ?? 'Professeur' }}
                            {{ $m->enseignant->prenom ?? '' }}
                        </div>

                    </div>

                    <span class="text-xs text-gray-400">
                        {{ $m->created_at?->format('d/m/Y H:i') }}
                    </span>

                </div>

                {{-- MESSAGE --}}
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $m->Message }}
                </p>

            </div>

        @empty

            <p class="text-gray-500">Aucun message</p>

        @endforelse

    </div>
</div>

@endsection