<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = Reclamation::with('user')
        ->orderBy('id', 'desc')
        ->paginate(3);

        return view('chef.reclamation', compact('reclamations'));
    }

    public function traiter($id)
    {
        $rec = Reclamation::findOrFail($id);
        $rec->update(['statut' => 'traite']);

        return back();
    }

    public function archiver($id)
    {
        $rec = Reclamation::findOrFail($id);
        $rec->update(['statut' => 'archive']);

        return back();
    }
}
