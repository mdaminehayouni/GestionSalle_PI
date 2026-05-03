@extends('layouts.chef')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">
    Réclamations
</h1>

@foreach($reclamations as $rec)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">

    <div class="flex items-start justify-between">

        <div class="flex gap-4">

            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                ⚠️
            </div>

            <div>
                <p class="font-semibold text-gray-800">
                    {{ $rec->titre }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Signalé par: {{ $rec->user->name ?? 'Unknown' }}
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    {{ $rec->description }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    {{ \Carbon\Carbon::parse($rec->created_at)->diffForHumans() }}
                </p>

                <p class="text-xs mt-1">
                    Status: 
                    <span class="
                        {{ $rec->statut == 'traite' ? 'text-green-600' : '' }}
                        {{ $rec->statut == 'archive' ? 'text-gray-500' : '' }}
                    ">
                        {{ $rec->statut }}
                    </span>
                </p>
            </div>

        </div>

        <div class="flex gap-2">
                <form method="POST" action="{{ route('reclamations.traiter', $rec->id) }}">
                    @csrf
                    <button class="px-3 py-1.5 bg-green-100 text-green-700 text-sm rounded-lg hover:bg-green-200">
                        Traiter
                    </button>
                </form>
        </div>
    </div>
    
</div>
@endforeach
<div class="mt-6">
        {{ $reclamations->links() }}
</div>

@endsection