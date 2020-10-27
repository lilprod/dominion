<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'description', 'lavage_price', 'repassage_price', 'nettoyage_price',
    ];

    public function depositedarticles()
    {
        return $this->hasMany('App\DepositedArticle');
    }
}
