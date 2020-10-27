<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositedArticle extends Model
{
    protected $fillable = [
        'article_id', 'designation', 'quantity', 'amount', 'order_id', 'client_id', 'client_name', 'user_id',
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function deposit()
    {
        return $this->belongsTo('App\Deposit');
    }

    public function checkedarticles()
    {
        return $this->hasMany('App\CheckedArticle');
    }
}
