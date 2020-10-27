<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Order as OrderResource;
use Validator;
use Carbon\Carbon;

class SearchController extends BaseController
{
    public function searchOrder(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_code' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order_code = $request->input('order_code');

     
        $order = Order::where('order_code', $order_code)
                        ->first();
      

        if($order != ''){

            if(($order->client_userid == auth()->user()->id) || ($order->collector_userid == auth()->user()->id)){

                return $this->sendResponse(new OrderResource($order), 'Order retrieved successfully.');

            }else{
                $response = [
                    'success' => false,
                    'data'    => [],
                    'message' =>'Access unauthorized!',
                ];
                return response()->json($response, 200);
            }
            
        }else{
            $response = [
                'success' => false,
                'data'    => [],
                'message' =>'Order not exist!',
            ];
            return response()->json($response, 200);
        }
    }
}
