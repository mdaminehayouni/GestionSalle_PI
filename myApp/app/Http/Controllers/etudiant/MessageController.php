<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function messages()
    {
        $user = Auth::user();

        // si relation user -> etudiant
        $etudiant = $user->etudiant;

        $classeId = $etudiant->classe_id ?? null;

        $messages = Message::with(['classe', 'enseignant'])
            ->where('classeId', $classeId)
            ->orderByDesc('created_at')
            ->get();
        return view('etudiant.messages', compact('messages'));
    }
}