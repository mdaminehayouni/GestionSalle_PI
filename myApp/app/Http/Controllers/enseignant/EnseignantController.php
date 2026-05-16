<?php

namespace App\Http\Controllers\enseignant;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Salle;
use App\Models\Seance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Reclamation;
use App\Models\Message;

class EnseignantController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | CRUD Enseignant (Chef)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $enseignants = User::where('role','enseignant')->get();

        return view('chef.gestionEnseignant', compact('enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'enseignant',
        ]);

        return redirect()->route('chef.gestionEnseignant');
    }

    public function edit(string $id)
    {
        $enseignant = User::where('role', 'enseignant')
            ->findOrFail($id);

        return view('chef.editEnseignant', compact('enseignant'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email',
        ]);

        $enseignant = User::where('role', 'enseignant')
            ->findOrFail($id);

        $enseignant->update([
            'name' => $request->nom,
            'email' => $request->email,
        ]);

        return redirect()->route('chef.gestionEnseignant');
    }

    public function destroy(string $id)
    {
        $enseignant = User::where('role', 'enseignant')
            ->findOrFail($id);

        $enseignant->delete();

        return redirect()->route('chef.gestionEnseignant');
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $sallesDisponibles = Salle::count();

        $reservationsRecentes = Seance::with('salle')
            ->where('enseignantId', Auth::user()->enseignant->id)
            ->orderByRaw("DAYOFWEEK(date)")
            ->get();

        $mesReservationsCount = Seance::where('enseignantId', Auth::user()->enseignant->id)->count();
        $mesReclamationsCount = Reclamation::where('user_id', Auth::id())->count();
        return view('enseignant.dashboard', [
            'sallesDisponibles' => $sallesDisponibles,
            'mesReservations' => $mesReservationsCount,
            'demandesEnCours' => $mesReclamationsCount,
            'reclamationsEnvoyees' => $mesReclamationsCount,
            'reservationsRecentes' => $reservationsRecentes,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EMPLOI
    |--------------------------------------------------------------------------
    */
    private function getCreneauFromHeure($heure)
    {
        $h = date('H:i', strtotime($heure));

        $creneaux = [
            '08:30' => '08:30 - 10:00',
            '10:15' => '10:15 - 11:45',
            '12:00' => '12:00 - 13:30',
            '13:30' => '13:30 - 15:00',
            '15:15' => '15:15 - 16:45',
            '17:00' => '17:00 - 18:30',
        ];

        return $creneaux[$h] ?? null;
    }

    public function emploie()
    {
        $jours = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi'
        ];

        $creneaux = [
            ['label' => '08:30 - 10:00'],
            ['label' => '10:15 - 11:45'],
            ['label' => '12:00 - 13:30'],
            ['label' => '13:30 - 15:00'],
            ['label' => '15:15 - 16:45'],
            ['label' => '17:00 - 18:30'],
        ];

        $emploi = [];

        $seances = Seance::with(['salle', 'classe'])
        ->where('enseignantId', Auth::user()->enseignant->id)
        ->orderBy('date')
        ->orderBy('heure_deb')
        ->get();

        $emploi = [];

        foreach ($seances as $s)
        {
            $jour = ucfirst(
                Carbon::parse($s->date)
                    ->locale('fr')
                    ->dayName
            );

            $slot = $this->getCreneauFromHeure($s->heure_deb);

            if (!$slot) continue;

            $emploi[$slot][$jour][] = [
                'matiere' => $s->matiere,
                'salle' => $s->salle->nomSalle ?? '',
                'classe' => $s->classe->libelle ?? '',
                'color' => 'bg-blue-600'
            ];
        }

        $weekLabel = Carbon::now()
            ->locale('fr')
            ->translatedFormat('d M Y');

        return view('enseignant.emploie', compact(
            'jours',
            'creneaux',
            'emploi',
            'weekLabel'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

    public function messages()
    {
        $classes = Classe::all();

        return view('enseignant.messages', compact('classes'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'contenu' => 'required',
            'classe_id' => 'required',
        ]);

        Message::create([
            'Message' => $request->contenu,
            'enseignantId' => Auth::user()->enseignant->id,
            'classeId' => $request->classe_id,
        ]);

        return back()->with(
            'success',
            'Message envoyé avec succès'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RECLAMATION
    |--------------------------------------------------------------------------
    */

    public function reclamations()
    {
        $salles = Salle::all();

        $reclamations = Reclamation::with('salle')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('enseignant.reclamations', compact(
            'salles',
            'reclamations'
        ));
    }

    public function storeReclamation(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        Reclamation::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'statut' => 'en_attente',
            'user_id' => Auth::id(),
            'salleId' => $request->salle_id,
        ]);

        return back()->with(
            'success',
            'Réclamation envoyée'
        );
    }

    public function destroyReclamation($id)
    {
        $reclamation = Reclamation::where('user_id', Auth::id())
            ->findOrFail($id);

        $reclamation->delete();

        return back()->with(
            'success',
            'Réclamation supprimée'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESERVATIONS
    |--------------------------------------------------------------------------
    */
    public function creneauxDisponibles(Request $request)
    {
        $date = $request->date;

        $allCreneaux = [
            ['08:30','10:00'],
            ['10:15','11:45'],
            ['12:00','13:30'],
            ['13:30','15:00'],
            ['15:15','16:45'],
            ['17:00','18:30'],
        ];
    
        $dayOfWeek = Carbon::parse($date)->dayOfWeek + 1; // DAYOFWEEK: 1=dimanche, 2=lundi, etc.

        $busy = Seance::where('enseignantId', Auth::user()->enseignant->id)
            ->whereRaw("DAYOFWEEK(date) = ?", [$dayOfWeek])
            ->get();

        $available = array_filter($allCreneaux, function ($c) use ($busy) {

            [$start, $end] = $c;

            foreach ($busy as $s) {
                if ($s->heure_deb < $end && $s->heure_fin > $start) {
                    return false;
                }
            }

            return true;
        });

        return response()->json(array_values($available));
    }
    public function classesDisponiblesReservation(Request $request)
    {
        $date = $request->date;
        $debut = $request->heure_deb;
        $fin = $request->heure_fin;

        $classes = Classe::whereDoesntHave('seances', function ($q) use ($date, $debut, $fin) {

            $q->whereRaw(
                "DAYOFWEEK(date) = DAYOFWEEK(?)",
                [$date]
            )
            ->where(function ($x) use ($debut, $fin) {

                $x->whereBetween('heure_deb', [$debut, $fin])
                ->orWhereBetween('heure_fin', [$debut, $fin])
                ->orWhere(function ($y) use ($debut, $fin) {

                    $y->where('heure_deb', '<=', $debut)
                        ->where('heure_fin', '>=', $fin);

                });

            });

        })->get();

        return response()->json($classes);
    }
    public function sallesDisponiblesReservation(Request $request)
    {
        $date = $request->date;
        $debut = $request->heure_deb;
        $fin = $request->heure_fin;

        $salles = Salle::whereDoesntHave('seances', function ($q) use ($date, $debut, $fin) {

            $q->whereRaw(
                "DAYOFWEEK(date) = DAYOFWEEK(?)",
                [$date]
            )
            ->where(function ($x) use ($debut, $fin) {
                $x->whereBetween('heure_deb', [$debut, $fin])
                    ->orWhereBetween('heure_fin', [$debut, $fin])
                    ->orWhere(function ($y) use ($debut, $fin) {
                        $y->where('heure_deb', '<=', $debut)
                        ->where('heure_fin', '>=', $fin);
                    });
            });

        })->get();

        return response()->json($salles);
    }
    public function reservations()
    {
        $classes = Classe::all();

        $reservations = Seance::with('salle')
            ->where('enseignantId', Auth::user()->enseignant->id)
            ->orderByRaw("DAYOFWEEK(date)")
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'salle' => $s->salle->nomSalle ?? '',
                    'date' => $s->date,
                    'debut' => substr($s->heure_deb, 0, 5),
                    'fin' => substr($s->heure_fin, 0, 5),
                    'status' => 'active',
                    'matiere' => $s->matiere,
                ];
            });

        return view('enseignant.reservation', compact(
            'classes',
            'reservations'
        ));
    }

        public function storeReservation(Request $request)
        {
            $request->validate([
                'matiere' => 'required|string',
                'date' => 'required|date',
                'heure_deb' => 'required',
                'heure_fin' => 'required',
                'classe_id' => 'required',
                'salle_id' => 'required',
            ]);
            $conflict = Seance::whereRaw(
                "DAYOFWEEK(date) = DAYOFWEEK(?)",
                [$request->date]
            )
            ->where(function ($q) use ($request) {

                $q->where(function ($x) use ($request) {
                    $x->where('salleId', $request->salle_id)
                    ->orWhere('classeId', $request->classe_id)
                    ->orWhere('enseignantId', Auth::user()->enseignant->id);
                });

            })
            ->where(function ($q) use ($request) {

                $q->where('heure_deb', '<', $request->heure_fin)
                ->where('heure_fin', '>', $request->heure_deb);

            })
            ->exists();

            if ($conflict) {
                return back()->withErrors('Conflit horaire détecté');
            }

            Seance::create([
                'matiere' => $request->matiere,
                'date' => $request->date,
                'heure_deb' => $request->heure_deb,
                'heure_fin' => $request->heure_fin,
                'enseignantId' => Auth::user()->enseignant->id,
                'classeId' => $request->classe_id,
                'salleId' => $request->salle_id,
            ]);

            return back()->with('success', 'Réservation effectuée');
        }
    public function destroyReservation($id)
    {
        $seance = Seance::where('enseignantId', Auth::user()->enseignant->id)
            ->findOrFail($id);

        $seance->delete();

        return back()->with(
            'success',
            'Réservation annulée'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SALLES
    |--------------------------------------------------------------------------
    */

    public function salles()
    {
        $salles = Salle::all()->map(function($s){
            return [
                'id' => $s->id,
                'nom' => $s->nomSalle,
                'dept' => 'Informatique',
                'cap' => $s->capacite ?? 30,
            ];
        });

        $seances = [
            [
                'num'=>1,
                'label'=>'Séance 1',
                'time'=>'08:30 – 10:00',
                'value'=>'08:30-10:00',
                'start'=>'08:30',
                'end'=>'10:00',
            ],
            [
                'num'=>2,
                'label'=>'Séance 2',
                'time'=>'10:15 – 11:45',
                'value'=>'10:15-11:45',
                'start'=>'10:15',
                'end'=>'11:45',
            ],
            [
                'num'=>3,
                'label'=>'Séance 3',
                'time'=>'12:00 – 13:30',
                'value'=>'12:00-13:30',
                'start'=>'12:00',
                'end'=>'13:30',
            ],
        ];

        $currentSeance = $seances[0];

        return view('enseignant.salles', compact(
            'salles',
            'seances',
            'currentSeance'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX SALLES DISPONIBLES
    |--------------------------------------------------------------------------
    */

    public function sallesDisponibles(Request $request)
    {
        return response()->json(
            Salle::select('id','nomSalle')->get()
        );
    }
}