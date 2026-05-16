<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::orderBy('id', 'desc')->get();
        return view('chef.gestionClasse', compact('classes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
            'niveau' => 'required|string',
        ]);

        Classe::create($request->all());

        return redirect()->route('chef.gestionClasse');
    }
    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:50',
            'niveau' => 'required|string',
        ]);

        $classe->update($request->all());

        return redirect()->route('chef.gestionClasse');
    }
    public function destroy($id)
    {
        try {
        $classe = Classe::findOrFail($id);
        $classe->delete();

        return redirect()->back()->with('success', 'Classe supprimée avec succès');
    }
    catch (QueryException $e) {
        return redirect()->back()->with('error',
            'Suppression impossible : cette classe est utilisée dans des séances.'
        );
    }
    }

}
