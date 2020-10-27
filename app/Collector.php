<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Collector extends Model
{
    use Rateable;
    
    public function getFullNameAttribute($value)
    {
       return ucfirst($this->name) . ' ' . ucfirst($this->firstname);
    }
}
