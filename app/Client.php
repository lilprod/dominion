<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Client extends Model
{
    protected $fillable = [
        'name', 'firstname', 'email', 'phone_number', 'address', 'profile_picture',
    ];

    use Rateable;
}
