<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    protected $fillable = ['titre', 'contenu', 'publie_par'];

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publie_par');
    }
}