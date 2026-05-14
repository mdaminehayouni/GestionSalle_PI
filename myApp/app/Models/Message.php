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

    public $timestamps = false;

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classeId');
    }
}