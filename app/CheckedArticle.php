<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckedArticle extends Model
{
    protected $fillable = [
        'order_id', 'deposited_article_id', 'status', 'client_id', 'client_name', 'user_id',
    ];

    public function depositedarticle()
    {
        return $this->belongsTo('App\DepositedArticle');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
