<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'email','fis_cod','address','city','postal_code', 'vat_number', 'typology'
    ];
}
