<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    protected $fillable = ['nom_original', 'chemin', 'type_mime', 'taille', 'depose_par'];

    public function deposant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'depose_par');
    }

    public function message(): HasOne
    {
        return $this->hasOne(Message::class);
    }
}