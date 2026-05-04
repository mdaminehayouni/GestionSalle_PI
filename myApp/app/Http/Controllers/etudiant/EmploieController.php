<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use Carbon\Carbon;

class EmploieController extends Controller
{
    public function emploieEtudiant()
    {
        $etudiant = auth()->user()->etudiant;

        $seances = Seance::with(['salle', 'enseignant'])
            ->where('classeId', $etudiant->classe_id)
            ->get()
            ->map(function ($s) {

                $date = Carbon::parse($s->date);

                $s->dayIndex = $date->dayOfWeekIso; // 1 = lundi

                $s->start = Carbon::parse($s->heure_deb)->format('H:i');
                $s->end   = Carbon::parse($s->heure_fin)->format('H:i');

                return $s;
            });

        return view('etudiant.emploie', compact('seances'));
    }
}