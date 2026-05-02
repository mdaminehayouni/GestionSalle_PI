@extends('layouts.chef')

@section('content')
<div class="p-8 fade-in">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des enseignants</h1>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition" onclick="openModal()">
            + Ajouter un enseignant
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Nom</th>
                    <th class="px-6 py-4">Prenom</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
            @foreach($enseignants as $e)
                <!-- Example row -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{$e->nom}}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{$e->prenom}}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{$e->user->email}}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center h-full gap-4">

                            <button class="text-blue-600 hover:text-blue-800 font-medium leading-none"
                                onclick="editEnseignant('{{ $e->id }}', '{{ $e->nom }}','{{$e->prenom}}', '{{ $e->user->email }}')">
                                Modifier
                            </button>

                            <form action="{{ route('chef.enseignant.destroy', $e->id) }}"
                                method="POST"
                                class="flex items-center m-0"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer cet enseignant ?')">

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

        <h2 class="text-lg font-bold mb-4">Enseignant</h2>

       <form id="enseignantForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <input type="hidden" name="id" id="enseignant_id">
            <p>Nom</p>
            <input type="text" name="nom" id="nom"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder ='Hayouni' required>
            <p>Prenom</p>
            <input type="text" name="prenom" id="prenom"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder ='Amine' required>
            <p>Email</p>
            <input type="email" name="email" id="email"
                class="w-full mb-3 border rounded-lg px-3 py-2" placeholder ='mdamine.hayouni@gmail.com' required>
            <p id="password_text">MotPasse</p>
            <input type="password" name="password" id="password" placeholder ='••••••••'
                class="w-full mb-3 border rounded-lg px-3 py-2">

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
    document.getElementById('enseignantForm').action = "{{ route('chef.enseignant.store') }}";
    document.getElementById('methodField').value = "POST";

    document.getElementById('nom').value = "";
    document.getElementById('prenom').value = "";
    document.getElementById('email').value = "";
    document.getElementById('password').style.display = "block";
    document.getElementById('password_text').style.display = "block";

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}
function editEnseignant(id, name,prenom, email) {

    document.getElementById('enseignantForm').action = `/chef/enseignant/${id}`;
    document.getElementById('methodField').value = "PUT";

    document.getElementById('nom').value = name;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;

    document.getElementById('password').style.display = "none";
    document.getElementById('password_text').style.display = "none";

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection