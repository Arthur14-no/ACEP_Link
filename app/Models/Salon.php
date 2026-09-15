<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salon extends Model
{
    protected $fillable = ['nom', 'visibilite', 'service_id', 'description', 'cree_par'];

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'salon_membres');
    }

    public function estVisiblePour(User $utilisateur): bool
    {
        if ($utilisateur->role === 'administrateur') {
            return true;
        }

        if ($this->visibilite === 'prive') {
            return $this->membres()->where('user_id', $utilisateur->id)->exists();
        }

        return true;
    }

    public function peutEcrire(User $utilisateur): bool
    {
        if (!$this->estVisiblePour($utilisateur)) {
            return false;
        }

        if ($this->visibilite === 'public_lecture_seule') {
            return in_array($utilisateur->role, ['administrateur', 'moderateur']);
        }

        return true;
    }
}