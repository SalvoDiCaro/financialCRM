<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complead extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'lead_id', 'fis_cod', 'date_of_birth', 'birth_place', 'job', 'contract_type', 'address', 'city_of_residence', 'postal_code'
    ];


    public function lead()
    {
        return $this->hasOne('App\Models\Lead');
    }

    public function partecipations()
    {
        return $this->belongsToMany('App\Models\Partecipation');
    }
}
