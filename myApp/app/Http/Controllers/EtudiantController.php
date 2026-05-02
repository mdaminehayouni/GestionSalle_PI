<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;

class EtudiantController extends Controller
{
    public function index(){
        $etudiants = Etudiant::all();

        return view('Etudiant.affiche',compact('etudiants'));
    }
}
