@extends('layouts.etudiant')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">Mes messages</h2>

    @forelse($messages as $m)

        <div class="bg-white shadow rounded-xl p-4 mb-4">

            <div class="text-sm text-gray-500 mb-1">
                Classe : {{ $m->classe->libelle ?? 'N/A' }}
            </div>

            <div class="font-semibold text-lg">
                {{ $m->Message }}
            </div>

        </div>

    @empty

        <div class="text-center text-gray-400">
            Aucun message pour votre classe
        </div>

    @endforelse

</div>

@endsection