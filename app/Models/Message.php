<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    // app/Message.php

    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['message','user_id','instance_id'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
