<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Message;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $etudiant = Auth::user()->etudiant;

        $nowDate = Carbon::today();
        $nowTime = Carbon::now()->format('H:i:s');
        $messages = Message::where('classeId', $etudiant->classe_id)
        ->orderBy('id', 'desc')
        ->take(3)
        ->get();
        $prochainCours = Seance::where('classeId', $etudiant->classe_id)
            ->where('date', $nowDate)
            ->where('heure_deb', '>=', $nowTime)
            ->orderBy('heure_deb')
            ->first();

        // fallback + stats (sinon Blade casse ou vide)
        $nbCours = Seance::where('classeId', $etudiant->classe_id)
        ->where('date', $nowDate)
        ->count();

        $heures = 0; // à améliorer plus tard
        $rattrapages = 0; // placeholder

        return view('etudiant.dashboard', compact(
            'prochainCours',
            'nbCours',
            'heures',
            'rattrapages',
            'messages'
        ));
    }
}
