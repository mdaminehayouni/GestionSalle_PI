@extends('layouts.chef')

@section('content')
<div class="p-8 fade-in">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Gestion des séances
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ajouter et gérer les séances de cours
            </p>
        </div>

        <button onclick="openModal()"
            class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
            + Ajouter une séance
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Matière</th>
                    <th class="px-6 py-4 text-left">Date</th>
                    <th class="px-6 py-4 text-left">Horaire</th>
                    <th class="px-6 py-4 text-left">Enseignant</th>
                    <th class="px-6 py-4 text-left">Classe</th>
                    <th class="px-6 py-4 text-left">Salle</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @foreach($seances as $seance)
                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $seance->matiere }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $seance->date }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $seance->heure_deb }} - {{ $seance->heure_fin }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $seance->enseignant->nom ?? '' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $seance->classe->libelle ?? '' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $seance->salle->nomSalle ?? '' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">

                            <button
                                onclick="editSeance(
                                    '{{ $seance->id }}',
                                    '{{ $seance->matiere }}',
                                    '{{ $seance->date }}',
                                    '{{ $seance->heure_deb }}',
                                    '{{ $seance->heure_fin }}',
                                    '{{ $seance->enseignantId }}',
                                    '{{ $seance->classeId }}',
                                    '{{ $seance->salleId }}'
                                )"
                                class="text-blue-600 hover:text-blue-800">
                                Modifier
                            </button>

                            <form action="{{ route('chef.seance.destroy', $seance->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer cette séance ?')"
                                style="display: inline; margin: 0; padding: 0;">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:text-red-800" style="background: none; border: none; padding: 0; margin: 0; cursor: pointer;">
                                    Supprimer
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div class="bg-white rounded-2xl p-6 w-full max-w-lg">

        <h2 class="text-lg font-bold mb-4">Séance</h2>

        <form id="seanceForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <p>Matière</p>
            <input type="text" name="matiere" id="matiere" placeholder="Matiere"
                class="w-full mb-3 border rounded-lg px-3 py-2" required>

            <p>Date</p>
            <input type="date" name="date" id="date"
                class="w-full mb-3 border rounded-lg px-3 py-2"
                onchange="filterAll()"
                required>

            <p>Horaire</p>
            <select name="horaire" id="horaire"
                class="w-full mb-3 border rounded-lg px-3 py-2"
                onchange="filterAll()" required>
                <option value="">Horaire</option>
                <option value="08:30-10:30">08:30 - 10:30</option>
                <option value="10:15-11:45">10:15 - 11:45</option>
                <option value="12:00-13:30">12:00 - 13:30</option>
                <option value="13:30-15:00">13:30 - 15:00</option>
                <option value="15:15-16:45">15:15 - 16:45</option>
                <option value="17:00-18:30">17:00 - 18:30</option>
            </select>

            <p>Enseignant</p>
            <select name="enseignantId" id="enseignant"
                class="w-full mb-3 border rounded-lg px-3 py-2">
                @foreach($enseignants as $e)
                    <option value="{{ $e->id }}">
                        {{ $e->nom }} {{ $e->prenom }}
                    </option>
                @endforeach
            </select>

            <p>Classe</p>
            <select name="classeId" id="classe"
                class="w-full mb-3 border rounded-lg px-3 py-2">
                @foreach($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                @endforeach
            </select>

            <p>Salle</p>
            <select name="salleId" id="salle"
                class="w-full mb-3 border rounded-lg px-3 py-2">
                <option value="">Choisir une salle</option>
            </select>

            <!-- Champs cachés pour heure_deb et heure_fin -->
            <input type="hidden" name="heure_deb" id="heure_deb" value="">
            <input type="hidden" name="heure_fin" id="heure_fin" value="">

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg">
                    Annuler
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Enregistrer
                </button>
            </div>

        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>

let currentSeanceId = null;

// Créer des maps pour accéder aux noms des salles et enseignants
window.sallesMap = {
    @foreach($salles as $salle)
        '{{ $salle->id }}': '{{ $salle->nomSalle }}',
    @endforeach
};

window.enseignantsMap = {
    @foreach($enseignants as $e)
        '{{ $e->id }}': '{{ $e->nom }} {{ $e->prenom }}',
    @endforeach
};

function openModal() {
    document.getElementById('seanceForm').reset();
    document.getElementById('seanceForm').action = "{{ route('chef.seance.store') }}";
    document.getElementById('methodField').value = "POST";
    
    document.getElementById('heure_deb').value = '';
    document.getElementById('heure_fin').value = '';
    document.getElementById('salle').innerHTML = `<option value="">Choisir une salle</option>`;

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function editSeance(id, matiere, date, hd, hf, ensId, classeId, salleId) {

    currentSeanceId = id;

    document.getElementById('seanceForm').action = `/chef/seance/${id}`;
    document.getElementById('methodField').value = "PUT";

    document.getElementById('matiere').value = matiere;
    document.getElementById('date').value = date;
    document.getElementById('horaire').value = `${hd}-${hf}`;
    document.getElementById('classe').value = classeId;

    // Stocker les IDs actuels pour les ajouter après le filtre
    window.currentEnseignantId = ensId;
    window.currentSalleId = salleId;

    filterAll(id);

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function filterAll(seanceId = null) {
    let date = document.getElementById('date').value;
    let horaire = document.getElementById('horaire').value;

    if (!date || !horaire) return;

    let [debut, fin] = horaire.split("-").map(s => s.trim());

    // SALLES
    fetch(`/salles-disponibles?date=${date}&heure_deb=${debut}&heure_fin=${fin}&seance_id=${seanceId}`)
        .then(res => res.json())
        .then(data => {
            let select = document.getElementById('salle');
            select.innerHTML = `<option value="">Choisir une salle</option>`;
            
            data.forEach(s => {
                select.innerHTML += `<option value="${s.id}">${s.nomSalle}</option>`;
            });
            
            // Toujours ajouter la salle actuelle si elle existe
            if (window.currentSalleId) {
                // Chercher si la salle est déjà dans la liste
                let alreadyExists = false;
                for (let option of select.options) {
                    if (option.value == window.currentSalleId) {
                        alreadyExists = true;
                        break;
                    }
                }
                
                // Si pas trouvée, l'ajouter
                if (!alreadyExists) {
                    let option = document.createElement('option');
                    option.value = window.currentSalleId;
                    option.text = (window.sallesMap[window.currentSalleId] || 'Salle') + ' (Actuelle)';
                    select.appendChild(option);
                }
                
                // Sélectionner la salle actuelle
                select.value = window.currentSalleId;
            }
        });

    // ENSEIGNANTS
    fetch(`/enseignants-disponibles?date=${date}&heure_deb=${debut}&heure_fin=${fin}&seance_id=${seanceId}`)
        .then(res => res.json())
        .then(data => {
            let select = document.getElementById('enseignant');
            select.innerHTML = `<option value="">Choisir un enseignant</option>`;
            
            data.forEach(e => {
                select.innerHTML += `<option value="${e.id}">${e.nom} ${e.prenom}</option>`;
            });
            
            // Toujours ajouter l'enseignant actuel s'il existe
            if (window.currentEnseignantId) {
                // Chercher si l'enseignant est déjà dans la liste
                let alreadyExists = false;
                for (let option of select.options) {
                    if (option.value == window.currentEnseignantId) {
                        alreadyExists = true;
                        break;
                    }
                }
                
                // Si pas trouvé, l'ajouter
                if (!alreadyExists) {
                    let option = document.createElement('option');
                    option.value = window.currentEnseignantId;
                    option.text = (window.enseignantsMap[window.currentEnseignantId] || 'Enseignant') + ' (Actuel)';
                    select.appendChild(option);
                }
                
                // Sélectionner l'enseignant actuel
                select.value = window.currentEnseignantId;
            }
        });
}

// split horaire avant la soumission
document.getElementById('seanceForm').addEventListener('submit', function(e) {
    let horaire = document.getElementById('horaire').value;
    
    if (horaire) {
        let [debut, fin] = horaire.split('-').map(s => s.trim());
        document.getElementById('heure_deb').value = debut;
        document.getElementById('heure_fin').value = fin;
    }
});

</script>

@endsection