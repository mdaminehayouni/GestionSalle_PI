@extends('layouts.chef')

@section('content')
<div class="p-8 fade-in">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Gestion des salles
        </h1>

        <button onclick="openModal()"
            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>

            Ajouter une salle
        </button>
    </div>

    <!-- TABLE CONTAINER -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEAD -->
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Salle</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-left">Capacité</th>
                        <th class="px-6 py-4 text-left">Disponibilité</th>
                        <th class="px-6 py-4 text-left">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                @foreach($salles as $salle)
                <tr class="hover:bg-gray-50 transition">

                    <!-- NOM -->
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $salle->nomSalle }}
                    </td>

                    <!-- DEPARTEMENT -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ $salle->type }}
                    </td>

                    <!-- CAPACITE -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ $salle->capacite }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        @if($salle->disponibilite)
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                Disponible
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                                Non disponible
                            </span>
                        @endif
                    </td>
                    <!-- ACTIONS -->
                    <td class="px-6 py-4 align-middle">
                        <div class="flex items-center justify-start gap-3">
                            <!-- EDIT -->
                            <button
                                onclick="editsalle('{{ $salle->id }}','{{ $salle->nomSalle }}','{{ $salle->type }}','{{ $salle->capacite }}','{{$salle->disponibilite}}')"
                                class="px-3 py-1.5 text-sm text-blue-600 hover:bg-blue-50 rounded-md transition">
                                Modifier
                            </button>
                            <!-- DELETE -->
                            <form action="{{ route('chef.salle.destroy', $salle->id) }}"
                                method="POST"
                                class="m-0 p-0"
                                onsubmit="return confirm('Supprimer cette salle ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-md transition">
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
    <div class="mt-8 px-4 flex-col items-center gap-3 ">
                {{ $salles->links() }}
    </div>
</div>
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div class="bg-white rounded-2xl p-6 w-full max-w-md">

        <h2 class="text-lg font-bold mb-4">Salle</h2>

       <form id="salleForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <input type="hidden" name="id" id="salle_id">
            <p>Nom Salle</p>
            <input type="text" name="nomSalle" id="nom"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder ='I10' required>
            <p>Type</p>
            <select name="type" id="type"
                class="w-full mb-3 border rounded-lg px-3 py-2"  placeholder ='Amphi' required>
                <option value="AMPHI">Amphi</option>
                <option value="TP">Tp</option>
                <option value="NORMAL" selected>Normal</option>
            </select>
            <p id="password_text">Capacité</p>
            <input type="text" name="capacite" id="cap" placeholder ='40'
                class="w-full mb-3 border rounded-lg px-3 py-2">
            <p>Disponibilité</p>
            <select name="disponibilite" id="disponibilite"
                class="w-full mb-3 border rounded-lg px-3 py-2">

                <option value="1">Disponible</option>
                <option value="0">Non disponible</option>

            </select>
            <div class="flex justify-end gap-2">
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
<script>
function openModal() {
    document.getElementById('salleForm').action = "{{ route('chef.salle.store') }}";
    document.getElementById('methodField').value = "POST";
    document.getElementById('disponibilite').value = "1";
    document.getElementById('nom').value = "";
    document.getElementById('type').value = "NORMAL";
    document.getElementById('cap').value = "";

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}
function editsalle(id, nomSalle, type,cap,disp) {

    document.getElementById('salleForm').action = `/chef/salle/${id}`;
    document.getElementById('methodField').value = "PUT";
    document.getElementById('disponibilite').value = String(disp);
    document.getElementById('nom').value = nomSalle;
    document.getElementById('type').value = type;
    document.getElementById('cap').value = cap;

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection