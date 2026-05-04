<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classe';

    protected $fillable = [
        'libelle',
        'niveau',
    ];

    public $timestamps = false;

    public function seances()
    {
        return $this->hasMany(Seance::class, 'classeId');
    }
}
