<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['nom'];

    public function utilisateurs(): HasMany
    {
        return $this->hasMany(User::class);
    }
}