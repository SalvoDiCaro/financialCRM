<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Prenotation extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id', 'spot_id', 'date_from', 'date_to'
    ];

}
