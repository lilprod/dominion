<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'delivery_code', 'order_id',	'order_code', 'quantity',	'order_amount', 'discount', 'left_pay',
        'order_date',	'date_retrait',	'status', 'client_id',	'client_name',	'client_email',	'client_address',
        'client_phone',	'client_userid',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
