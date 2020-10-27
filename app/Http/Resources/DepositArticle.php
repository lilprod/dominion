<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositArticle extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'article_title' => $this->article_title,
            'designation' => $this->designation,
            'unit_price' => $this->unit_price,
            'order_id' => $this->order_id,
            'client_id' => $this->client_id,
            'client_name' => $this->client_name,
            'client_firstname' => $this->client_firstname,
            'client_userid' => $this->client_userid,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
