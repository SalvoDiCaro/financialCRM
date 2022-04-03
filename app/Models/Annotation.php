<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{

    // app/Note.php

    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['note','user_id','dealer_id'];

}
