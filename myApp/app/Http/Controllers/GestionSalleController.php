<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use Illuminate\Http\Request;

class GestionSalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salles = Salle::paginate(5);
        return view('chef.gestionSalle',compact('salles'));
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
            'nomSalle'=>'required',
            'capacite'=>'required',
            'type'=>'required',
            'disponibilite'=>'required'
        ]);
        Salle::create([
            'nomSalle' => $request->nomSalle, // or name
            'capacite' => $request->capacite,
            'type' => $request->type,
            'disponibilite'=>(int)$request->disponibilite
        ]);
        return redirect()->route('chef.gestionSalle');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'nomSalle' => 'required',
            'type' => 'required',
            'capacite' => 'required',
            'disponibilite'=>'required'
        ]);

        $salle = Salle::findOrFail($id);

        $salle->update([
            'nomSalle' => $request->nomSalle,
            'type' => $request->type,
            'capacite' => $request->capacite,
            'disponibilite'=>(int)$request->disponibilite
        ]);

        return redirect()->route('chef.gestionSalle');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();
        return redirect()->route('chef.gestionSalle');
    }
}
