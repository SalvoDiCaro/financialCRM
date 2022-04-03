<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Practice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'instance_id',
        'practice_number',
        'paper_digital' ,
        'stipulation_date',
        'cpi_awards' ,
        'fire' ,
        'complete_fire' ,
        'injuries' ,
        'ppl' ,
        'life' ,
        'spread_band' ,
        'spread' ,
        'cpi_number' ,
        'fire_amount' ,
        'complete_fire_amount' ,
        'injuries_amount' ,
        'ppl_amount' ,
        'life_amount' ,
        'ltv_band' ,
        'dealer_id',
        'notary'
    ];


    public function request()
    {
        return $this->hasOne('App\Models\Request');
    }
}
