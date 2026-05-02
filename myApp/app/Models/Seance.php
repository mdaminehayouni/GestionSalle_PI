<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    public $timestamps = false;
    protected $table = 'seance';
    protected $fillable = ['matiere','date','heure_deb','heure_fin','enseignantId','classeId','salleId'];
    
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salleId');
    }
    
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignantId');
    }
    
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classeId');
    }
}
