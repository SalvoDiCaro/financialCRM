<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lead_id', 'user_id', 'is_direct'
    ];

    public function lead()
    {
        return $this->hasOne('App\Models\Lead');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
