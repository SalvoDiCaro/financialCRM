<?php
 
namespace App\Events;
 
use App\Models;
 
class UserRegistered
{
     
    public $model;
 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;   
    }
}
