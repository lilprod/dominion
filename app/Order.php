<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function depositedarticles()
    {
        return $this->hasMany('App\DepositedArticle');
    }

    public function checkedarticles()
    {
        return $this->hasMany('App\CheckedArticle');
    }

    protected $dates = ['created_at', 'delivery_date'];

    public function date_convert($date){
        return mb_convert_encoding($date, "UTF-8", mb_detect_encoding($date, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }

}
