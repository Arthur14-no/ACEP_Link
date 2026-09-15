<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueSalon extends Model
{
    protected $table = 'vues_salons';

    public $timestamps = false;

    protected $fillable = ['user_id', 'salon_id', 'vu_a'];
}