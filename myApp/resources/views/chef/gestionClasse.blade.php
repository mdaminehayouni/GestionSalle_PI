@extends('layouts.chef')

@section('content')
<div class="p-8 fade-in">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des classes</h1>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition" onclick="openModal()">
            + Ajouter classe
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Libelle</th>
                    <th class="px-6 py-4">Niveau</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
            @foreach($classes as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $c->libelle }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $c->niveau }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center h-full gap-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium leading-none"
                                onclick="editClasse('{{ $c->id }}', '{{ $c->libelle }}','{{ $c->niveau }}')">
                                Modifier
                            </button>

                            <form action="{{ route('chef.classe.destroy', $c->id) }}"
                                method="POST"
                                class="flex items-center m-0"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer cette classe ?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-red-600 hover:text-red-800 font-medium leading-none">
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

<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div class="bg-white rounded-2xl p-6 w-full max-w-md">

        <h2 class="text-lg font-bold mb-4">Classe</h2>

       <form id="form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <input type="hidden" name="id" id="classe_id">
            <p>Libellé</p>
            <input type="text" name="libelle" id="libelle"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder="L2DSI1" required>
            <p>Niveau</p>
            <input type="text" name="niveau" id="niveau"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder="2" required>

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
    document.getElementById('form').action = "{{ route('chef.classe.store') }}";
    document.getElementById('methodField').value = "POST";

    document.getElementById('libelle').value = "";
    document.getElementById('niveau').value = "";

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function editClasse(id, libelle, niveau) {

    document.getElementById('form').action = `/chef/classe/${id}`;
    document.getElementById('methodField').value = "PUT";

    document.getElementById('libelle').value = libelle;
    document.getElementById('niveau').value = niveau;

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
@if(session('error'))
    alert("{{ session('error') }}");
@endif
</script>
@endsection