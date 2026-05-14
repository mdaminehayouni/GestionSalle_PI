@extends('layouts.enseignant')
@section('page-title', 'Réclamations')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- FORM --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-lg font-bold mb-5">Nouvelle réclamation</h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-100 text-green-700 text-sm font-semibold">
                <i class="fa-solid fa-circle-check mr-1"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-100 text-red-700 text-sm">
                <ul class="list-disc ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('enseignant.reclamations.store') }}" class="space-y-4">
            @csrf

            {{-- TYPE --}}
            <div>
                <label class="text-xs font-bold text-gray-600 uppercase">Type de réclamation</label>
                <select name="type"
                        class="w-full mt-1 px-3 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                    <option value="">-- Sélectionner --</option>
                    <option value="materiel">Problème matériel</option>
                    <option value="absence">Absence enseignant</option>
                    <option value="conflit">Conflit de réservation</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            {{-- SALLE --}}
            <div>
                <label class="text-xs font-bold text-gray-600 uppercase">Salle concernée</label>
                <select name="salle_id"
                        class="w-full mt-1 px-3 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">-- Aucune salle --</option>
                    @forelse($salles as $s)
                        <option value="{{ $s->id ?? $s['id'] }}">
                            {{ $s->nomSalle }}
                        </option>
                    @empty
                    @endforelse
                </select>
            </div>

            {{-- TITRE --}}
            <div>
                <label class="text-xs font-bold text-gray-600 uppercase">Titre (optionnel)</label>
                <input type="text"
                       name="titre"
                       placeholder="Résumé de votre réclamation..."
                       class="w-full mt-1 px-3 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="text-xs font-bold text-gray-600 uppercase">Description</label>
                <textarea name="description"
                          required
                          rows="5"
                          placeholder="Décrivez votre problème..."
                          class="w-full mt-1 px-3 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                Envoyer au chef département
            </button>
        </form>
    </div>

    {{-- HISTORY --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-lg font-bold mb-5">Historique</h2>

        <div class="space-y-4">

            @forelse($reclamations as $r)

                <div class="border rounded-xl p-4 hover:shadow transition">

                    <div class="flex justify-between items-start gap-3">

                        <div class="flex-1">

                            <div class="font-semibold text-gray-900">
                                {{ $r->titre ?? ucfirst($r->type) }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ \Illuminate\Support\Str::limit($r->description, 70) }}
                            </div>

                            <div class="text-xs text-gray-400 mt-2">
                                {{ optional($r->created_at)->format('d M Y') }}
                            </div>

                        </div>

                        {{-- STATUS --}}
                        @if(($r->statut ?? 'en_attente') === 'resolu')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Résolue
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                En attente
                            </span>
                        @endif

                        {{-- DELETE --}}
                        <form method="POST"
                              action="{{ route('enseignant.reclamations.destroy', $r->id) }}"
                              onsubmit="return confirm('Êtes-vous sûr ?')">

                            @csrf
                            @method('DELETE')

                            <button class="ml-2 text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="text-center text-gray-400 py-10">
                    <i class="fa-regular fa-inbox text-3xl mb-2"></i>
                    <p>Aucune réclamation envoyée</p>
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection