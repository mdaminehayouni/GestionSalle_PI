<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $enseignants = User::where('role','enseignant')->get();
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
        User::create([
            'name' => $request->nom, // or name
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'enseignant',
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
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);

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

        $enseignant = User::where('role', 'enseignant')->findOrFail($id);

        $enseignant->update([
            'name' => $request->nom,
            'email' => $request->email,
        ]);

        return redirect()->route('chef.gestionEnseignant');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);
        $enseignant->delete();
        return redirect()->route('chef.gestionEnseignant');
    }
}
