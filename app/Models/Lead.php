<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'surname', 'phone', 'email', 'channel', 'current_state', 'notes','document','fis_cod','date_of_birth','birth_place','job','contract_type','work_since',
        'annual_income','address','city_of_residence','postal_code','marital_status','work_notes','loan_notes','company_id', 'sector'
    ];
}
