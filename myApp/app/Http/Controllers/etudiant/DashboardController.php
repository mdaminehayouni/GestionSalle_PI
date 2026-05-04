<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $etudiant = Auth::user()->etudiant;

        $nowDate = Carbon::today();
        $nowTime = Carbon::now()->format('H:i:s');

        $prochainCours = Seance::where('classeId', $etudiant->classe_id)
            ->where(function ($q) use ($nowDate, $nowTime) {
                $q->where('date', '>', $nowDate)
                ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                    $q2->where('date', $nowDate)
                        ->where('heure_deb', '>=', $nowTime);
                });
            })
            ->orderBy('date')
            ->orderBy('heure_deb')
            ->first();

        // fallback + stats (sinon Blade casse ou vide)
        $nbCours = Seance::where('classeId', $etudiant->classe_id)->count();

        $heures = 0; // à améliorer plus tard
        $rattrapages = 0; // placeholder

        return view('etudiant.dashboard', compact(
            'prochainCours',
            'nbCours',
            'heures',
            'rattrapages'
        ));
    }
}
