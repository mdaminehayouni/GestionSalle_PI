<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GestionEnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::with('user')->get();
        return view('chef.gestionEnseignant',compact('enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);
        $user=User::create([
            'name' => $request->nom, // or name
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'enseignant',
        ]);

        Enseignant::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);
        return redirect()->route('chef.gestionEnseignant');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        return view('chef.editEnseignant', compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email',
        ]);

        $enseignant = Enseignant::findOrFail($id);

        $enseignant->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);
        $enseignant->user->update([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email
        ]);

        return redirect()->route('chef.gestionEnseignant');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        // supprimer user aussi
        $enseignant->delete();
        $enseignant->user->delete();
        // puis enseignant
        return redirect()->route('chef.gestionEnseignant');
    }
}
