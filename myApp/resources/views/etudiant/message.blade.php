@extends('layouts.etudiant')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Messages</h2>
        <p class="text-sm text-gray-500">Communications de vos enseignants</p>
    </div>

    {{-- LIST --}}
    <div class="space-y-4">

        @forelse($messages as $m)

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 hover:shadow-md transition">

                {{-- TOP BAR --}}
                <div class="flex justify-between items-start mb-3">

                    <div class="flex items-center gap-3">

                        {{-- avatar --}}
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold uppercase">
                            {{ substr($m->enseignant->prenom ?? 'P', 0, 1) }}
                        </div>

                        <div>
                            <div class="font-semibold text-gray-800">
                                {{ $m->enseignant->nom }} {{ $m->enseignant->prenom }}
                            </div>

                            <div class="text-xs text-gray-400">
                                Enseignant
                            </div>
                        </div>

                    </div>

                    {{-- DATE --}}
                    <div class="text-xs text-gray-400">
                        {{ $m->created_at?->format('d/m/Y H:i') }}
                    </div>

                </div>

                {{-- BADGE CLASSE --}}
                <div class="mb-3">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                        Classe : {{ $m->classe->libelle ?? 'N/A' }}
                    </span>
                </div>

                {{-- MESSAGE --}}
                <div class="text-gray-700 leading-relaxed">
                    {{ $m->Message }}
                </div>

            </div>

        @empty

            <div class="text-center py-12">
                <div class="text-gray-300 text-5xl mb-3">📭</div>
                <p class="text-gray-500">Aucun message disponible</p>
            </div>

        @endforelse

    </div>
</div>

@endsection