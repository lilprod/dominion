<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'order_code' => $this->order_code,
            'service_id' => $this->service_id,
            'service_title' => $this->service_title,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'action' => $this->action,
            'order_amount' => $this->order_amount,
            'amount_paid' => $this->amount_paid,
            'discount' => $this->discount,
            'taxe' => $this->taxe,
            'total_net' => $this->total_net,
            'left_pay' => $this->left_pay,
            'meeting_place' => $this->meeting_place,
            'meeting_longitude' => $this->meeting_longitude,
            'meeting_latitude' => $this->meeting_latitude,
            'place_delivery' => $this->place_delivery,
            'delivery_longitude' => $this->delivery_longitude,
            'delivery_latitude' => $this->delivery_latitude,
            'delivery_date' => $this->delivery_date,
            'identifier' => $this->identifier,
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
