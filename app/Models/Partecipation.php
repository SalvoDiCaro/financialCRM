<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partecipation extends Model
{

    protected $fillable = [
        'instance_id', 'lead_id', 'typology'
    ];

    public function compleads()
    {
        return $this->hasMany('App\Models\Clients');
    }
}
