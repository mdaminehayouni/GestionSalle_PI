<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    public $timestamps = false;
    protected $table = 'salle';
    protected $fillable = ['nomSalle','capacite','type','disponibilite'];
    public function seances()
    {
        return $this->hasMany(Seance::class, 'salleId');
    }
}
