@extends('layouts.enseignant')
@section('page-title', 'Messages')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-6">

        {{-- HEADER --}}
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-paper-plane text-blue-600"></i>
            Envoyer un message aux étudiants
        </h2>

        <p class="text-sm text-gray-500 mt-1 mb-6">
            Communiquez directement avec vos étudiants
        </p>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-xl bg-green-100 text-green-700 text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl bg-red-100 text-red-700 text-sm">
                <ul class="list-disc ml-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- FORM --}}
        <form method="POST" action="{{ route('enseignant.messages.store') }}" class="space-y-5">
            @csrf
        {{-- CLASSE --}}
        <div>
            <label class="text-xs font-bold text-gray-600 uppercase">
                Classe destinataire
            </label>

            <select name="classe_id"
                    required
                    class="w-full mt-2 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">

                <option value="">-- Sélectionner une classe --</option>

                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">
                        {{ $classe->libelle }}
                    </option>
                @endforeach

            </select>
        </div>
            {{-- TEXTAREA --}}
            <div>
                <label class="text-xs font-bold text-gray-600 uppercase">
                    Votre message
                </label>

                <textarea name="contenu"
                          required
                          maxlength="2000"
                          placeholder="Écrivez votre message ici..."
                          rows="6"
                          class="w-full mt-2 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">

                <i class="fa-solid fa-paper-plane"></i>
                Envoyer aux étudiants

            </button>

        </form>

    </div>

</div>

@endsection