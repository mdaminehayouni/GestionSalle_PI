<?php

namespace App\Http\Controllers\chef;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Models\Salle;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $countSalle=Salle::count();
        $countReclamation = Reclamation::count();
        $countEnseignant = User::where('role','enseignant')->count();
        return view('chef.dashboard',compact('countSalle','countEnseignant','countReclamation'));
    }
}
