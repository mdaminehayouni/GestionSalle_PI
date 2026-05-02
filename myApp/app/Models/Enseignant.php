<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    public $timestamps = false;
    protected $table = 'enseignants';
    protected $fillable = ['nom','prenom','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function seances()
    {
        return $this->hasMany(Seance::class, 'enseignantId');
    }
}
