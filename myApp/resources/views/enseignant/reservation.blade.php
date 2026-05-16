@extends('layouts.enseignant')

@section('content')

<div class="flex justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold">Mes Séances</h2>
        <p class="text-gray-500 text-sm">Gestion des salles</p>
    </div>

    <button onclick="openModal()"
        class="px-4 py-2 bg-blue-600 text-white rounded-xl">
        + Nouvelle réservation
    </button>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow overflow-hidden">
<table class="w-full text-sm table-fixed">

<thead class="bg-gray-50 text-gray-500">
<tr>
    <th class="p-4 text-left">Salle</th>
    <th class="p-4 text-left">Matière</th>
    <th class="p-4 text-left">Jour</th>
    <th class="p-4 text-left">Horaire</th>
    <th class="p-4 text-left w-32">Action</th>
</tr>
</thead>

<tbody>
@forelse($reservations as $r)
<tr class="border-t hover:bg-gray-50">

    <td class="p-4 align-middle">
        {{ $r['salle'] }}
    </td>

    <td class="p-4 align-middle">
        {{ $r['matiere'] }}
    </td>

    <td class="p-4 align-middle">
        {{ \Carbon\Carbon::parse($r['date'])->locale('fr')->dayName }}
    </td>

    <td class="p-4 align-middle">
        {{ $r['debut'] }} - {{ $r['fin'] }}
    </td>

    <td class="p-4 align-middle">
        <form action="{{ route('enseignant.reservations.destroy', $r['id']) }}"
              method="POST"
              onsubmit="return confirm('Supprimer cette réservation ?')">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="text-red-600 hover:text-red-800 font-medium">
                Supprimer
            </button>

        </form>
    </td>

</tr>
@empty
<tr>
    <td colspan="5" class="p-6 text-center text-gray-400">
        Aucune réservation
    </td>
</tr>
@endforelse
</tbody>

</table>
</div>

{{-- MODAL --}}
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

<div class="bg-white w-full max-w-lg p-6 rounded-2xl">

<h2 class="text-xl font-bold mb-4">Réserver une salle</h2>

<form method="POST" action="{{ route('enseignant.reservations.store') }}">
@csrf

{{-- MATIERE --}}
<input type="text"
       name="matiere"
       placeholder="Matière"
       class="w-full border p-2 rounded mb-3"
       required>

{{-- DATE --}}
<input type="date"
       name="date"
       id="date"
       class="w-full border p-2 rounded mb-3"
       onchange="loadCreneaux()"
       required>

{{-- HORAIRE --}}
<select id="horaire"
        class="w-full border p-2 rounded mb-3"
        onchange="filterSalles()"
        required>
    <option value="">Horaire</option>
    <option value="08:30-10:00">08:30 - 10:00</option>
    <option value="10:15-11:45">10:15 - 11:45</option>
    <option value="12:00-13:30">12:00 - 13:30</option>
    <option value="13:30-15:00">13:30 - 15:00</option>
    <option value="15:15-16:45">15:15 - 16:45</option>
    <option value="17:00-18:30">17:00 - 18:30</option>
</select>

{{-- CLASSE --}}
<select name="classe_id" class="w-full border p-2 rounded mb-3">
@foreach($classes as $c)
<option value="{{ $c->id }}">{{ $c->libelle }}</option>
@endforeach
</select>

{{-- SALLE --}}
<select name="salle_id" id="salle" class="w-full border p-2 rounded mb-3"></select>

{{-- hidden --}}
<input type="hidden" name="heure_deb" id="heure_deb">
<input type="hidden" name="heure_fin" id="heure_fin">

<div class="flex justify-end gap-2">
<button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Annuler</button>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Réserver</button>
</div>

</form>

</div>
</div>
@endsection

@push('scripts')
<script>

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

// Charger les créneaux disponibles quand la date change
function loadCreneaux() {
    let date = document.getElementById('date').value;

    if (!date) return;

    fetch(`/enseignant/creneaux-disponibles?date=${date}`)
        .then(r => r.json())
        .then(data => {
            let select = document.getElementById('horaire');
            select.innerHTML = `<option value="">Horaire</option>`;

            if (data.length === 0) {
                select.innerHTML += `<option disabled>Aucun créneau disponible</option>`;
                return;
            }

            data.forEach(c => {
                select.innerHTML += `<option value="${c[0]}-${c[1]}">${c[0]} - ${c[1]}</option>`;
            });
        })
        .catch(err => console.error('Erreur créneaux:', err));
}

// Charger les classes et salles disponibles quand l'horaire change
function filterSalles() {
    let date = document.getElementById('date').value;
    let horaire = document.getElementById('horaire').value;

    if (!date || !horaire) {
        alert('Veuillez sélectionner une date et un horaire');
        return;
    }

    let [debut, fin] = horaire.split('-');
    
    document.getElementById('heure_deb').value = debut.trim();
    document.getElementById('heure_fin').value = fin.trim();

    // 🔵 CLASSES DISPONIBLES
    fetch(`/enseignant/classes-disponibles-reservation?date=${date}&heure_deb=${debut.trim()}&heure_fin=${fin.trim()}`)
        .then(r => r.json())
        .then(data => {
            let select = document.querySelector('select[name="classe_id"]');
            select.innerHTML = `<option value="">Classe disponible</option>`;
            data.forEach(c => {
                select.innerHTML += `<option value="${c.id}">${c.libelle}</option>`;
            });
        })
        .catch(err => console.error('Erreur classes:', err));

    // 🔵 SALLES DISPONIBLES
    fetch(`/enseignant/salles-disponibles-reservation?date=${date}&heure_deb=${debut.trim()}&heure_fin=${fin.trim()}`)
        .then(r => r.json())
        .then(data => {
            let select = document.getElementById('salle');
            select.innerHTML = `<option value="">Salle disponible</option>`;
            data.forEach(s => {
                select.innerHTML += `<option value="${s.id}">${s.nomSalle}</option>`;
            });
        })
        .catch(err => console.error('Erreur salles:', err));
}
</script>
@endpush