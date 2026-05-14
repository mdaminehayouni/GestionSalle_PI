<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $table = 'reclamations';

    protected $fillable = [
        'titre',
        'description',
        'type',
        'statut',
        'user_id',
        'salleId',
    ];

    public $timestamps = false;

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salleId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}