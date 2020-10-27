<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Delivery extends JsonResource
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
            'delivery_code' => $this->delivery_code,
            'order_id' => $this->order_id,
            'order_code' => $this->order_code,
            'service_id' => $this->service_id,
            'service_title' => $this->service_title,
            'action' => $this->action,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'order_amount' => $this->order_amount,
            'amount_paid' => $this->amount_paid,
            'codepromo_id' => $this->codepromo_id,
            'code_promo' => $this->code_promo,
            'discount' => $this->discount,
            'left_pay' => $this->left_pay,
            'order_date' => $this->order_date,
            'delivery_date' => $this->delivery_date,
            'meeting_place' => $this->meeting_place,
            'meeting_longitude' => $this->meeting_longitude,
            'meeting_latitude' => $this->meeting_latitude,
            'place_delivery' => $this->place_delivery,
            'delivery_longitude' => $this->delivery_longitude,
            'delivery_latitude' => $this->delivery_latitude,
            'client_id' => $this->client_id,
            'client_name' => $this->client_name,
            'client_firstname' => $this->client_firstname,
            'client_email' => $this->client_email,
            'client_address' => $this->client_address,
            'client_phone' => $this->client_phone,
            'client_userid' => $this->client_userid,
            'collector_id' => $this->collector_id,
            'collector_name' => $this->collector_name,
            'collector_firstname' => $this->collector_firstname,
            'collector_email' => $this->collector_email,
            'collector_address' => $this->collector_address,
            'collector_phone' => $this->collector_phone,
            'collector_userid' => $this->collector_userid,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
