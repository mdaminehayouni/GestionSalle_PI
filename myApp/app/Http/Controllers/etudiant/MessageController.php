<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class messageController extends Controller
{
    use App\Models\Message;
use Illuminate\Support\Facades\Auth;

public function messages()
{
    // récupérer la classe de l'étudiant connecté
    $etudiant = Auth::user();

    $classeId = $etudiant->classeId; // adapte selon ton schéma

    $messages = Message::with('classe')
        ->where('classeId', $classeId)
        ->orderBy('id', 'desc')
        ->get();

    return view('etudiant.messages', compact('messages'));
}
}
