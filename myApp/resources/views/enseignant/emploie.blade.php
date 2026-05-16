@extends('layouts.enseignant')
@section('page-title', 'Emploi du temps')

@section('content')

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
    @foreach($creneaux as $slot)

        <div class="grid grid-cols-7 border-t">

            {{-- HEURE --}}
            <div class="p-4 text-sm text-gray-500 font-medium">
                {{ $slot['label'] }}
            </div>

            {{-- JOURS --}}
            @foreach($jours as $day)

                <div class="p-2">

                    @if(isset($emploi[$slot['label']][$day]))

                        @foreach($emploi[$slot['label']][$day] as $event)

                            <div class="p-3 rounded-lg bg-blue-100">

                                <p class="text-xs font-semibold text-blue-800">
                                    {{ $event['matiere'] }}
                                </p>

                                <p class="text-xs text-blue-600">
                                    {{ $event['salle'] }}
                                </p>
                                <p class="text-xs text-blue-600">
                                    {{ $event['classe'] }}
                                </p>

                            </div>

                        @endforeach

                    @endif

                </div>

            @endforeach

        </div>

    @endforeach

</div>

</div>

@endsection