@extends('layouts.enseignant')
@section('page-title', 'Salles disponibles')

@php
    $currentSeance = $currentSeance ?? null;
    $seances = $seances ?? [
        ['num'=>1,'label'=>'Séance 1','time'=>'08:30 – 10:30','value'=>'08:30-10:30','start'=>'08:30','end'=>'10:30'],
        ['num'=>2,'label'=>'Séance 2','time'=>'10:30 – 12:30','value'=>'10:30-12:30','start'=>'10:30','end'=>'12:30'],
        ['num'=>3,'label'=>'Séance 3','time'=>'13:30 – 15:30','value'=>'13:30-15:30','start'=>'13:30','end'=>'15:30'],
        ['num'=>4,'label'=>'Séance 4','time'=>'15:30 – 18:00','value'=>'15:30-18:00','start'=>'15:30','end'=>'18:00'],
    ];
    $salles = $salles ?? collect();
@endphp

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Salles disponibles maintenant</h2>

        @if($currentSeance)
            <p class="text-sm text-gray-500 mt-1">
                {{ $currentSeance['label'] }} · {{ $currentSeance['time'] }}
            </p>
        @else
            <p class="text-sm text-gray-500 mt-1">Aucune séance en cours</p>
        @endif
    </div>
</div>

{{-- BANNER --}}
@if($currentSeance)
    <div class="flex items-center gap-3 px-4 py-3 mb-5 rounded-xl border border-blue-200 bg-blue-50 text-blue-700 font-semibold">
        <i class="fa-solid fa-clock"></i>
        {{ $currentSeance['label'] }} en cours — salles disponibles maintenant
    </div>
@else
    <div class="flex items-center gap-3 px-4 py-3 mb-5 rounded-xl border bg-gray-50 text-gray-500">
        <i class="fa-solid fa-moon"></i>
        Aucune séance active en ce moment
    </div>
@endif

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="text-left p-4">Salle</th>
                <th class="text-left p-4">Département</th>
                <th class="text-left p-4">Capacité</th>
                <th class="text-left p-4">Statut</th>
                <th class="text-left p-4">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        @forelse($salles as $salle)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-semibold text-gray-900">{{ $salle['nom'] }}</td>
                <td class="p-4 text-gray-600">{{ $salle['dept'] ?? 'N/A' }}</td>
                <td class="p-4 text-gray-600">{{ $salle['cap'] }} places</td>

                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                        Disponible
                    </span>
                </td>

                <td class="p-4">
                    @if($currentSeance)
                        <button
                            onclick="openModal({{ $salle['id'] }}, '{{ addslashes($salle['nom']) }}', {{ $salle['cap'] }})"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition"
                        >
                            Réserver
                        </button>
                    @else
                        <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg text-sm font-semibold cursor-not-allowed">
                            Indisponible
                        </button>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-10 text-center text-gray-400">
                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>
                    Aucune salle disponible
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-[480px] max-w-[95%] rounded-2xl p-6">

        <h3 class="text-lg font-bold mb-1">Réserver une salle</h3>
        <p id="modalMeta" class="text-sm text-gray-500 mb-4"></p>

        <form method="POST" action="{{ route('enseignant.reservations.store') }}" id="resaForm">
            @csrf
            <input type="hidden" name="salle_id" id="salle_id">

            <div class="mb-4">
                <label class="text-xs font-bold text-gray-600 uppercase">Date</label>
                <input type="date"
                       name="date"
                       id="dateInput"
                       class="w-full mt-2 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="text-xs font-bold text-gray-600 uppercase">Séance</label>

                <div class="space-y-2 mt-2">
                    @foreach($seances as $s)
                        <label id="seance-card-{{ $s['num'] }}"
                               class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer hover:border-blue-500">

                            <input type="radio"
                                   name="creneau"
                                   value="{{ $s['value'] }}"
                                   id="seance-radio-{{ $s['num'] }}"
                                   class="accent-blue-600">

                            <div>
                                <div class="font-semibold text-sm">{{ $s['label'] }}</div>
                                <div class="text-xs text-gray-500">{{ $s['time'] }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg">
                    Annuler
                </button>

                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold">
                    Confirmer
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id, nom, cap) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');

    document.getElementById('salle_id').value = id;
    document.getElementById('modalMeta').textContent = nom + ' · ' + cap + ' places';

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateInput').value = today;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

document.getElementById('modal').addEventListener('click', function(e){
    if(e.target === this) closeModal();
});
</script>
@endpush