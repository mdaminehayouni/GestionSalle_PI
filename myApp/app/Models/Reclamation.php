<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    public $timestamps = false;
    protected $table = 'reclamations';
    protected $fillable = [
        'titre',
        'description',
        'type',
        'statut',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
