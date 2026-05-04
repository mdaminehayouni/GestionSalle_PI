@extends('layouts.etudiant')

@section('content')

@php
$jours = [
    1 => 'Lundi',
    2 => 'Mardi',
    3 => 'Mercredi',
    4 => 'Jeudi',
    5 => 'Vendredi',
    6 => 'Samedi'
];

$creneaux = [
    ['08:30','10:00'],
    ['10:15','11:45'],
    ['12:00','13:30'],
    ['13:30','15:00'],
    ['15:15','16:45'],
    ['17:00','18:30'],
];
@endphp

<div class="space-y-6">

<h3 class="text-xl font-bold text-gray-800">
    Mon emploi du temps
</h3>

<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

    {{-- HEADER --}}
    <div class="grid grid-cols-7 bg-gray-50 border-b">
        <div></div>
        @foreach($jours as $jour)
            <div class="p-4 text-center font-medium text-sm text-gray-600">
                {{ $jour }}
            </div>
        @endforeach
    </div>

    {{-- GRID --}}
    @foreach($creneaux as $creneau)

        @php
            [$startSlot, $endSlot] = $creneau;
        @endphp

        <div class="grid grid-cols-7 border-t">

            {{-- heure --}}
            <div class="p-4 text-sm text-gray-500 font-medium">
                {{ $startSlot }} - {{ $endSlot }}
            </div>

            {{-- jours --}}
            @foreach($jours as $index => $jour)

                @php
                    $cours = $seances->first(function($s) use ($index, $startSlot, $endSlot) {
                        return $s->dayIndex == $index
                            && $s->start == $startSlot
                            && $s->end == $endSlot;
                    });
                @endphp

                <div class="p-2">

                    @if($cours)
                        <div class="p-3 rounded-lg bg-blue-100">

                            <p class="text-xs font-semibold text-blue-800">
                                {{ $cours->matiere }}
                            </p>

                            <p class="text-xs text-blue-600">
                                {{ $cours->salle->nomSalle ?? '' }}
                            </p>

                            <p class="text-xs text-blue-500">
                                {{ $cours->start }} - {{ $cours->end }}
                            </p>

                        </div>
                    @endif

                </div>

            @endforeach

        </div>

    @endforeach

</div>

</div>

@endsection