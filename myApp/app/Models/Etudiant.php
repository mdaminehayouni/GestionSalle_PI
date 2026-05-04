<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiant';
    public $timestamps = false;
    protected $fillable = [
    'nom',
    'prenom',
    'user_id',
    'classe_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'idclasse');
    }

}
