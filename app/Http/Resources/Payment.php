<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
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
            'order_id' => $this->order_id,
            'order_code' => $this->order_code,
            'tx_reference' => $this->tx_reference,
            'identifier' => $this->identifier,
            'payment_reference' => $this->payment_reference,
            'date_payment' => $this->date_payment,
            'telephone' => $this->telephone,
            'status' => $this->status,
            'paymentmode_id' => $this->paymentmode_id,
            'paymentmode_title' => $this->paymentmode_title,
            'description' => $this->description,
            'order_service' => $this->order_service,
            'order_amount' => $this->order_amount,
            'client_id' => $this->client_id,
            'client_name' => $this->client_name,
            'client_firstname' => $this->client_firstname,
            'client_email' => $this->client_email,
            'client_address' => $this->client_address,
            'client_userid' => $this->client_userid,
            'collector_id' => $this->collector_id,
            'collector_name' => $this->collector_name,
            'collector_firstname' => $this->collector_firstname,
            'collector_email' => $this->collector_email,
            'collector_address' => $this->collector_address,
            'collector_phone' => $this->collector_phone,
            'collector_userid' => $this->collector_userid,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
