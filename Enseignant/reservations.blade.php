@extends('enseignant.layouts.app')

@section('page-title', 'Mes réservations')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>
        <h2 class="text-2xl font-bold">
            Mes réservations
        </h2>

        <p class="text-gray-500 text-sm">
            Gestion des réservations des salles
        </p>
    </div>

    <button onclick="openModal()"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        + Nouvelle réservation
    </button>

</div>

<!-- LISTE -->

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100 text-left">

            <tr>
                <th class="p-4">Salle</th>
                <th class="p-4">Date</th>
                <th class="p-4">Horaire</th>
                <th class="p-4">Statut</th>
                <th class="p-4">Action</th>
            </tr>

        </thead>

        <tbody>

        @foreach($reservations as $r)

            <tr class="border-t">

                <td class="p-4">
                    {{ $r['salle'] }}
                </td>

                <td class="p-4">
                    {{ $r['date'] }}
                </td>

                <td class="p-4">
                    {{ $r['debut'] }} - {{ $r['fin'] }}
                </td>

                <td class="p-4">

                    @if($r['status'] == 'active')

                        <span class="text-green-600 font-semibold">
                            Active
                        </span>

                    @else

                        <span class="text-gray-500">
                            Terminée
                        </span>

                    @endif

                </td>

                <td class="p-4">

                    @if($r['status'] == 'active')

                    <form method="POST"
                        action="{{ route('enseignant.reservations.destroy', $r['id']) }}">

                        @csrf
                        @method('DELETE')

                        <button class="text-red-600">
                            Annuler
                        </button>

                    </form>

                    @endif

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<!-- MODAL -->

<div id="modal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-2xl p-6">

        <h2 class="text-xl font-bold mb-4">
            Réserver une salle
        </h2>

        <form method="POST"
            action="{{ route('enseignant.reservations.store') }}">

            @csrf

            <p>Date</p>

            <input type="date"
                name="date"
                id="date"
                class="w-full border rounded-lg px-3 py-2 mb-3"
                onchange="filterSalles()"
                required>

            <p>Horaire</p>

            <select id="horaire"
                class="w-full border rounded-lg px-3 py-2 mb-3"
                onchange="filterSalles()"
                required>

                <option value="">
                    Choisir un horaire
                </option>

                <option value="08:30-10:00">
                    08:30 - 10:00
                </option>

                <option value="10:15-11:45">
                    10:15 - 11:45
                </option>

                <option value="12:00-13:30">
                    12:00 - 13:30
                </option>

                <option value="13:30-15:00">
                    13:30 - 15:00
                </option>

                <option value="15:15-16:45">
                    15:15 - 16:45
                </option>

            </select>

            <p>Classe</p>

            <select
                name="classe_id"
                class="w-full border rounded-lg px-3 py-2 mb-3">

                @foreach($classes as $c)

                    <option value="{{ $c->id }}">
                        {{ $c->libelle }}
                    </option>

                @endforeach

            </select>

            <p>Salle disponible</p>

            <select
                name="salle_id"
                id="salle"
                class="w-full border rounded-lg px-3 py-2 mb-3"
                required>

                <option value="">
                    Choisir une salle
                </option>

            </select>

            <input type="hidden"
                name="creneau"
                id="creneau">

            <div class="flex justify-end gap-2 mt-4">

                <button type="button"
                    onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg">

                    Annuler

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">

                    Réserver

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openModal() {

    document.getElementById('modal')
        .classList.remove('hidden');

    document.getElementById('modal')
        .classList.add('flex');
}

function closeModal() {

    document.getElementById('modal')
        .classList.add('hidden');
}

function filterSalles() {

    let date = document.getElementById('date').value;

    let horaire = document.getElementById('horaire').value;

    if(!date || !horaire) return;

    document.getElementById('creneau').value = horaire;

    let [debut, fin] = horaire.split('-');

    fetch(`/enseignant/salles-disponibles-reservation?date=${date}&heure_deb=${debut}&heure_fin=${fin}`)

    .then(res => res.json())

    .then(data => {

        let select = document.getElementById('salle');

        select.innerHTML =
            `<option value="">Choisir une salle</option>`;

        data.forEach(s => {

            select.innerHTML +=
            `<option value="${s.id}">
                ${s.nomSalle}
            </option>`;

        });

    });

}

</script>

@endsection
