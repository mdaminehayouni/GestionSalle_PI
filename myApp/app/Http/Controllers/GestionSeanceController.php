<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\Salle;
use App\Models\Seance;
use App\Models\User;
use Illuminate\Http\Request;

class GestionSeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seances = Seance::with(['salle', 'enseignant', 'classe'])->paginate(5);
        $enseignants = Enseignant::all();
        $salles = Salle::all();
        $classes = Classe::all();

    return view('chef.gestionSeance', compact(
        'seances',
        'enseignants',
        'salles',
        'classes'
    ));
    }

    public function disponibles(Request $request)
    {
        $date = $request->date;
        $debut = $request->heure_deb;
        $fin = $request->heure_fin;
        $seanceId = $request->seance_id;

        $salles = Salle::whereDoesntHave('seances', function ($q) use ($date, $debut, $fin, $seanceId) {
            $q->where('date', $date)
            ->where(function ($x) use ($debut, $fin) {
                $x->whereBetween('heure_deb', [$debut, $fin])
                    ->orWhereBetween('heure_fin', [$debut, $fin])
                    ->orWhere(function ($y) use ($debut, $fin) {
                        $y->where('heure_deb', '<=', $debut)
                        ->where('heure_fin', '>=', $fin);
                    });
            })
            ->when($seanceId, function ($q) use ($seanceId) {
                $q->where('id', '!=', $seanceId);
            });
        })->get();

        return response()->json($salles);
    }
    public function enseignantsDisponibles(Request $request)
    {
        $date = $request->date;
        $debut = $request->heure_deb;
        $fin = $request->heure_fin;
        $seanceId = $request->seance_id;

        $enseignants = Enseignant::whereDoesntHave('seances', function ($q) use ($date, $debut, $fin, $seanceId) {
            $q->where('date', $date)
            ->where(function ($x) use ($debut, $fin) {
                $x->whereBetween('heure_deb', [$debut, $fin])
                    ->orWhereBetween('heure_fin', [$debut, $fin])
                    ->orWhere(function ($y) use ($debut, $fin) {
                        $y->where('heure_deb', '<=', $debut)
                        ->where('heure_fin', '>=', $fin);
                    });
            })
            ->when($seanceId, function ($q) use ($seanceId) {
                $q->where('id', '!=', $seanceId);
            });
        })->get();

        return response()->json($enseignants);
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
            'matiere' => 'required',
            'date' => 'required|date',
            'heure_deb' => 'required',
            'heure_fin' => 'required',
            'enseignantId' => 'required',
            'classeId' => 'required',
            'salleId' => 'required',
        ]);

        Seance::create([
            'matiere' => $request->matiere,
            'date' => $request->date,
            'heure_deb' => $request->heure_deb,
            'heure_fin' => $request->heure_fin,
            'enseignantId' => $request->enseignantId,
            'classeId' => $request->classeId,
            'salleId' => $request->salleId,
        ]);

        return redirect()->route('chef.gestionSeance');
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
            'matiere' => 'required',
            'date' => 'required|date',
            'heure_deb' => 'required',
            'heure_fin' => 'required',
            'enseignantId' => 'required',
            'classeId' => 'required',
            'salleId' => 'required',
        ]);

        $seance = Seance::findOrFail($id);

        $seance->update([
            'matiere' => $request->matiere,
            'date' => $request->date,
            'heure_deb' => $request->heure_deb,
            'heure_fin' => $request->heure_fin,
            'enseignantId' => $request->enseignantId,
            'classeId' => $request->classeId,
            'salleId' => $request->salleId,
        ]);

        return redirect()->route('chef.gestionSeance');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seance = Seance::findOrFail($id);
        $seance->delete();

        return redirect()->route('chef.gestionSeance');
    }
}
