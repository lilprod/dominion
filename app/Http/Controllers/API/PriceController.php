<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\KiloPrice as KiloPriceResource;
use App\Http\Resources\Article as ArticleResource;
use App\KiloPrice;
use Illuminate\Http\Request;

class PriceController extends BaseController
{
    public function kiloprice()
    {
        $prices = KiloPrice::all();

        return $this->sendResponse(KiloPriceResource::collection($prices), 'Kilo prices retrieved successfully.');
    }


    public function articleprice()
    {
        $prices = Article::all();

        //return $this->sendResponse(ArticleResource::collection($prices), 'Articles with their prices retrieved successfully.');
        
        return $this->sendResponse($prices, 'Articles with their prices retrieved successfully.');
    }
}
