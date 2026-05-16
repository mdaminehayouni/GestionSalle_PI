<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = [
        'Message',
        'enseignantId',
        'classeId',
    ];

    // IMPORTANT: activer created_at / updated_at
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classeId', 'id');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignantId');
    }
}