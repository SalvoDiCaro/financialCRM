<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 'details'
    ];

    public function compleads()
    {
        return $this->belongsToMany('App\Models\Client');
    }
}
