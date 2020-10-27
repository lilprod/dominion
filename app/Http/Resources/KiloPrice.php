<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KiloPrice extends JsonResource
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
            'lavage_price' => $this->lavage_price,
            'express_price' => $this->express_price,
            'repassage_price' => $this->repassage_price,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
