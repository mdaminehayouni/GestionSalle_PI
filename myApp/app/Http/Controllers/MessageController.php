<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function messages()
    {
        $user = Auth::user();
        
        // Récupérer l'étudiant connecté
        $etudiant = Etudiant::where('user_id', $user->id)->first();
        
        if (!$etudiant) {
            return view('etudiant.message', ['messages' => []]);
        }

        // Récupérer les messages pour la classe de l'étudiant
        $messages = Message::where('classeId', $etudiant->classe_id)
            ->with('classe')
            ->get();

        return view('etudiant.message', compact('messages'));
    }
}
