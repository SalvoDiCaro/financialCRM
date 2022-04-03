<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'user_id', 'branch', 'current_state','amount','finality','duration','spread','rating','property_cost','property_value','first_erogation',
        'inquest','property_address','property_city','property_postal_code','property_extension_address','property_extension_city','property_extension_postal_code',
        'family_members','housing_situation', 'product_type', 'consap'
    ];


    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function practice()
    {
        return $this->belongsTo('App\Models\Practice');
    }

    public function partecipations()
    {
        return $this->belongsToMany('App\Models\Partecipation');
    }

}
