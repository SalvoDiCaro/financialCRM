<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    // app/Note.php

    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['note','user_id','lead_id'];

}
