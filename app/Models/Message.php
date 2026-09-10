<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['contenu', 'expediteur_id', 'salon_id', 'destinataire_id'];

    public function expediteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }
}