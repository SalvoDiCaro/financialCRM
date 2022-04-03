<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commitment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dealer_id', 'agent_id', 'current_state'
    ];

}
