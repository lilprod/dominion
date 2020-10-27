<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Payment as PaymentResource;
use Validator;
use App\Payment;
use App\User;
use App\Notification;
use App\Client;
use App\Collector;
use App\Order;
use App\Delivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Carbon\Carbon;

class PaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$payments = Payment::all();
        $payments = auth()->user()->mypayments();
    
        //return $this->sendResponse(PaymentResource::collection($payments), 'Payments retrieved successfully.');
        return $this->sendResponse($payments, 'Payments retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
            'client_userid' => 'required',
            'amount'  => 'required',
            'collector_userid' => 'required',
            'description' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $client = Client::where('user_id', $request->client_userid)
                            ->first();

        $collector = Collector::where('user_id', $request->collector_userid)
                               ->first();

        $order = Order::findOrFail($request->order_id);

            
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = new Notification();
        
        $notification1 = new Notification();
        
        $user = User::findOrFail($client->user_id);
        
        $token = $user->firebase_token;

        $user1 = User::findOrFail($collector->user_id);
        
        $token1 = $user1->firebase_token;
        
        $message_FR = 'Votre paiement a été bien enregistré';
        
        $message_EN = 'Your payment has been saved';
        
        $message1 = 'Le paiement du client a été effectué avec succès';
        
        $title_FR = 'Notification de paiement';
        
        $title_EN = 'Payment notification';
        
        $title = 'Notification de paiement';

        if($user->lang == 'FR'){
            
            $notification->message = $message_FR;
            
            $notification->title = $title_FR;
        }else{
            $notification->message = $message_EN;
            
            $notification->title = $title_EN;
        }

        $notification1->message = $message1;
        
        $notification1->title = $title;

        $notification->save();
        
        $notification1->save();
        

            $msg = array (
            'message'=> $notification->message,
            'id'=> $notification->id,
            'title'=> $notification->title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_COLLECT',
            'object'=> $order,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );

            $msg1 = array (
            'message'=> $message1,
            'id'=> $notification1->id,
            'title'=> $title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_COLLECT',
            'object'=> $order,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );
        
            $fields = array(//'registration_ids'=>$registrationIds,
                'to'   => $token, //single token
                'data' =>$msg
            );

            $fields1 = array(//'registration_ids'=>$registrationIds,
                'to'   => $token1, //single token
                'data' =>$msg1
            );
        
            $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
            'Content-Type: application/json'
            );
    
            //curl client
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            $result =  json_decode($result, true);
            
            //curl collector
            $ch1 = curl_init();
            curl_setopt( $ch1,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch1,CURLOPT_POST, true );
            curl_setopt( $ch1,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch1,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch1,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode($fields1));
            $result1 = curl_exec($ch1);
            curl_close($ch1);
            $result1 =  json_decode($result1, true);


                if(($result['success'] == 1) && ($result1['success'] == 1) ) {

                $req = Notification::findOrFail($notification->id);
                
                $req->reception_date = Carbon::now();
                
                $req->notif_id = $result['results'][0]['message_id'];
                
                $req->status = 1;
                
                $req->order_id = $order->id;
                
                $req->receiver_id = $order->client_userid;
                
                $req->save();
                

                $req1 = Notification::findOrFail($notification1->id);
                
                $req1->reception_date = Carbon::now();
                
                $req1->notif_id = $result1['results'][0]['message_id'];
                
                $req1->status = 1;
                
                $req1->order_id = $order->id;
                
                $req1->receiver_id = $collector->user_id;
                
                $req1->save();
                

                $payment = new Payment();
                
                $payment->order_id = $request->order_id;
                
                $payment->order_code = $order->order_code;
                
                $payment->order_service = $order->service_title;
                
                $payment->order_amount = $request->amount;
                
                $payment->description = $request->description;
                
                $payment->paymentmode_title = 'ESPECES';
                
                $payment->client_userid = $request->client_userid;
                
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $order->amount_paid = $request->amount;
                
                if($order->amount_paid >= $order->order_amount){
                    
                    $order->left_pay = 0;
                    
                }else{
                    
                    $order->left_pay = ($order->order_amount - $order->amount_paid);
                }
                
                $order->status = 2;
                
                $order->save();
        
                $payment->save();
        
                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
                
            }elseif ($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $order->client_userid;
                $req->save();

                $payment = new Payment();
                $payment->order_id = $request->order_id;
                $payment->order_code = $order->order_code;
                $payment->order_service = $order->service_title;
                $payment->order_amount = $request->amount;
                $payment->description = $request->description;
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $request->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $order->amount_paid = $request->amount;
                
                if($order->amount_paid >= $order->order_amount){
                    
                    $order->left_pay = 0;
                    
                }else{
                    
                    $order->left_pay = ($order->order_amount - $order->amount_paid);
                }
                $order->status = 2;
                
                $order->save();

                $payment->save();

                $req1 = Notification::findOrFail($notification1->id);
                
                $req1->delete();

                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');

            }elseif ($result1['success'] == 1) {

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->receiver_id = $collector->user_id;
                $req1->save();

                $payment = new Payment();
                $payment->order_id = $request->order_id;
                $payment->order_code = $order->order_code;
                $payment->order_service = $order->service_title;
                $payment->order_amount = $request->amount;
                $payment->description = $request->description;
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $request->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $order->amount_paid = $request->amount;
                
                if($order->amount_paid >= $order->order_amount){
                    
                    $order->left_pay = 0;
                }else{
                    
                    $order->left_pay = ($order->order_amount - $order->amount_paid);
                }
                
                $order->status = 2;
                
                $order->save();

                $payment->save();

                $req = Notification::findOrFail($notification->id);
                
                $req->delete();

                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
            }


    }
    
    public function payLeft(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
            'client_userid' => 'required',
            'amount'  => 'required',
            'collector_userid' => 'required',
            'description' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $order = Order::findOrFail($request->order_id);
        
        $old_pay = 0;
        
        $new_pay = 0;
        
        $old_pay = $order->amount_paid;
        
        $new_pay = $order->amount_paid + $request->amount;
        
        $client = Client::where('user_id', $request->client_userid)
                            ->first();

        $collector = Collector::where('user_id', $request->collector_userid)
                               ->first();

        
        if($order->amount <= $new_pay)
        {
            
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = new Notification();
        
        $notification1 = new Notification();

        $user = User::findOrFail($client->user_id);
        
        $token = $user->firebase_token;

        $user1 = User::findOrFail($collector->user_id);
        
        $token1 = $user1->firebase_token;
        
        $message_FR = 'Votre paiement a été bien enregistré';
        
        $message_EN = 'Your payment has been saved';
        
        $message1 = 'Le paiement du client a été effectué avec succès';
        
        $title_FR = 'Notification de paiement';
        
        $title_EN = 'Payment notification';
        
        $title = 'Notification de paiement';

        if($user->lang == 'FR'){
            $notification->message = $message_FR;
            $notification->title = $title_FR;
        }else{
            $notification->message = $message_EN;
            $notification->title = $title_EN;
        }

        $notification1->message = $message1;
        
        $notification1->title = $title;

        $notification->save();
        
        $notification1->save();
        

            $msg = array (
            'message'=> $notification->message,
            'id'=> $notification->id,
            'title'=> $notification->title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_PARTIAL_PAYMENT',
            'object'=> $order,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );

            $msg1 = array (
            'message'=> $message1,
            'id'=> $notification1->id,
            'title'=> $title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_PARTIAL_PAYMENT',
            'object'=> $order,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );
        
            $fields = array(//'registration_ids'=>$registrationIds,
                'to'   => $token, //single token
                'data' =>$msg
            );

            $fields1 = array(//'registration_ids'=>$registrationIds,
                'to'   => $token1, //single token
                'data' =>$msg1
            );
        
            $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
            'Content-Type: application/json'
            );
    
            //curl client
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            $result =  json_decode($result, true);
            
            //curl collector
            $ch1 = curl_init();
            curl_setopt( $ch1,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch1,CURLOPT_POST, true );
            curl_setopt( $ch1,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch1,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch1,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode($fields1));
            $result1 = curl_exec($ch1);
            curl_close($ch1);
            $result1 =  json_decode($result1, true);


                if(($result['success'] == 1) && ($result1['success'] == 1) ) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $order->client_userid;
                $req->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->receiver_id = $collector->user_id;
                $req1->save();

                $payment = new Payment();
                $payment->order_id = $request->order_id;
                $payment->order_code = $order->order_code;
                $payment->order_service = $order->service_title;
                $payment->order_amount = $request->amount;
                $payment->description = $request->description;
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $request->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $delivery = Delivery::where('order_id', $order->id)->first();
                
                $order->amount_paid = $old_pay + $request->amount;
                    
                $order->left_pay = 0;
                    
                $delivery->left_pay = 0;
                    
                $delivery->amount_paid = $old_pay + $request->amount;

                $order->status = 2;

                $order->save();

                $delivery->save();

                $payment->save();
        
                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
                
            }elseif ($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $order->client_userid;
                $req->save();

                $payment = new Payment();
                $payment->order_id = $request->order_id;
                $payment->order_code = $order->order_code;
                $payment->order_service = $order->service_title;
                $payment->order_amount = $request->amount;
                $payment->description = $request->description;
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $request->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $delivery = Delivery::where('order_id', $order->id)->first();
                
                $order->amount_paid = $old_pay + $request->amount;
                    
                $order->left_pay = 0;
                    
                $delivery->left_pay = 0;
                    
                $delivery->amount_paid = $old_pay + $request->amount;

                $order->status = 2;

                $order->save();

                $delivery->save();

                $payment->save();

                $req1 = Notification::findOrFail($notification1->id);

                $req1->delete();

                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');

            }elseif ($result1['success'] == 1) {

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->receiver_id = $collector->user_id;
                $req1->save();

                $payment = new Payment();
                $payment->order_id = $request->order_id;
                $payment->order_code = $order->order_code;
                $payment->order_service = $order->service_title;
                $payment->order_amount = $request->amount;
                $payment->description = $request->description;
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $request->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;
                $payment->collector_userid = $request->collector_userid;
                $payment->collector_id = $collector->id;
                $payment->collector_name = $collector->name;
                $payment->collector_firstname = $collector->firstname;
                $payment->collector_email = $collector->email;
                $payment->collector_address = $collector->address;
                $payment->collector_phone = $collector->phone_number;
                $payment->status = 1;
                
                $delivery = Delivery::where('order_id', $order->id)->first();
                
                $order->amount_paid = $old_pay + $request->amount;
                    
                $order->left_pay = 0;
                    
                $delivery->left_pay = 0;
                    
                $delivery->amount_paid = $old_pay + $request->amount;

                $order->status = 2;

                $order->save();

                $delivery->save();

                $payment->save();
                

                $req = Notification::findOrFail($notification->id);
                
                $req->delete();

                return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
            }

            
        }else{
            
            $response = [
                'success' => true,
                'data'    => $order,
                'message' =>'Insuffisant amount!',
            ];

            return response()->json($response, 200);
            
        }
        
    }


    public function checkout(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
            'client_userid' => 'required',
            'identifier' => 'required',
            'description' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        //$data = [];

       /*  $url = 'http://pressingmobile-tg.mon.world/washman/public/payments/create';

        $ch = curl_init();
        
        // Set here required headers
    	$headers = array(
        'accept: ',
        'accept-language: en-US,en;q=0.8',
        'Content-Type: application/json',
        );

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return $this->sendError('cURL Error #: '.$err);
            //echo "cURL Error #:" . $err;
        } else {
	        //print_r(json_decode($response));
            $data = json_decode($response, true);
            /* add payment ID to session **/
            //Session::put('identifier', $data->{'identifier'});

            //return redirect()->route('payments.create', compact('data'));
            //return redirect()->route('payments.create')->with('success','Veuillez retourner à votre application WASHMAN pour confirmer votre paiement');

            /* $response = [
                'success' => true,
                'data'    => $data,
                'message' =>'Réponse du confirmation de paiement!',
            ];
            return response()->json($response, 200); 
        } */

            $send = [
                'auth_token' => 'a81d1e51-bf4c-4fa1-ad94-ef30eb442c58',
                'identifier' => $input['identifier'],
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://paygateglobal.com/api/v2/status"            ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($send),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $result = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return $this->sendError('cURL Error #: '.$error);
            //echo "cURL Error #:" . $err;
        }else{

            $data = json_decode($result);
            $status = $data->{'status'};

            if($status == 0){

                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

                $notification = new Notification();
                $notification1 = new Notification();

                $order = Order::findOrFail($input['order_id']);

                //$registrationIds = $request->registrationIds;
                $user = User::findOrFail($request->client_userid);
                
                $token = $user->firebase_token;

                $user1 = User::findOrFail($order->collector_userid);
                
                $token1 = $user1->firebase_token;
             
                $message_FR = 'Votre paiement a été bien enregistré';
        
                $message_EN = 'Your payment has been saved';
                
                $message1 = 'Le paiement du client a été effectué avec succès';
                
                $title_FR = 'Notification de paiement';
                
                $title_EN = 'Payment notification';
        
                $message1 = 'Le paiement du client a été effectué avec succès';
                
                $title = 'Notification de paiement';

                if($user->lang == 'FR'){
                    $notification->message = $message_FR;
                    $notification->title = $title_FR;
                }else{
                    $notification->message = $message_EN;
                    $notification->title = $title_EN;
                }

                $notification1->message = $message1;
                
                $notification1->title = $title;

                $notification->save();
                
                $notification1->save();

                $msg = array (
                    'message'=> $notification->message,
                    'id'=> $notification->id,
                    'title'=> $notification->title,
                    'soundname'=> 'default',
                    'android_channel_id'=> 'dominion_channel',
                    'description' => 'dominion notification',
                    'type'=> 'CLOSE_COLLECT',
                    'object'=> $order,
                    'subtitle'=> null,
                    'tickerText'=> null,
                    'vibrate'=>1,
                    /*'sound'=>1,*/
                    'largeIcon'=>'large_icon',
                    'smallIcon'=>'small_icon'
                    );

                $msg1 = array (
                    'message'=> $message1,
                    'id'=> $notification1->id,
                    'title'=> $title,
                    'soundname'=> 'default',
                    'android_channel_id'=> 'dominion_channel',
                    'description' => 'dominion notification',
                    'type'=> 'CLOSE_COLLECT',
                    'object'=> $order,
                    'subtitle'=> null,
                    'tickerText'=> null,
                    'vibrate'=>1,
                    /*'sound'=>1,*/
                    'largeIcon'=>'large_icon',
                    'smallIcon'=>'small_icon'
                    );
                
                    $fields = array(//'registration_ids'=>$registrationIds,
                        'to'   => $token, //single token
                        'data' =>$msg
                    );

                    $fields1 = array(//'registration_ids'=>$registrationIds,
                        'to'   => $token1, //single token
                        'data' =>$msg1
                    );
                
                    $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
                    'Content-Type: application/json'
                    );
            
                    //curl client
                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
                    $result1 = curl_exec($ch);
                    curl_close($ch);
                    $result1 =  json_decode($result1, true);
                    
                    //curl collector
                    $ch1 = curl_init();
                    curl_setopt( $ch1,CURLOPT_URL, $fcmUrl);
                    curl_setopt( $ch1,CURLOPT_POST, true );
                    curl_setopt( $ch1,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch1,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch1,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode($fields1));
                    $result2 = curl_exec($ch1);
                    curl_close($ch1);
                    $result2 =  json_decode($result2, true);


                    if(($result1['success'] == 1) && ($result2['success'] == 1) ) {


                    $req = Notification::findOrFail($notification->id);
                    $req->reception_date = Carbon::now();
                    $req->notif_id = $result1['results'][0]['message_id'];
                    $req->status = 1;
                    $req->order_id = $order->id;
                    $req->receiver_id = $order->client_userid;
                    $req->save();

                    $req1 = Notification::findOrFail($notification1->id);
                    $req1->reception_date = Carbon::now();
                    $req1->notif_id = $result2['results'][0]['message_id'];
                    $req1->status = 1;
                    $req1->order_id = $order->id;
                    $req1->receiver_id = $order->collector_userid;
                    $req1->save();


                    $payment = new Payment();
                    $payment->identifier = $data->{'identifier'};
                    $payment->tx_reference = $data->{'tx_reference'};
                    $payment->payment_reference = $data->{'payment_reference'};
                    $payment->status = 0;
                    $date = $data->{'datetime'};
                    $payment->date_payment = Carbon::parse($date)->toDateTimeString();
                    $payment->order_amount = $data->{'amount'};
                    $payment->paymentmode_title = $data->{'payment_method'};
                    $payment->telephone = $input['phone'];
                    $payment->description = $input['description'];
                    
                    $payment->order_id = $input['order_id'];
                    
                    $payment->order_code = $order->order_code;
                    $payment->order_service = $order->service_title;

                    $payment->client_userid = $input['client_userid'];
                    $client = Client::where('user_id', $payment->client_userid)
                                        ->first();

                    $payment->client_id = $client->id;
                    $payment->client_name = $client->name;
                    $payment->client_firstname = $client->firstname;
                    $payment->client_email = $client->email;
                    $payment->client_address = $client->address;
                    $payment->client_phone = $client->phone_number;
                    $order->status = 2;

                    $payment->save();

                    $order->save();

                    return $this->sendResponse(new PaymentResource($payment), 'Paiement effectué avec succès.');

                    } elseif ($result1['success'] == 1) {

                        $req = Notification::findOrFail($notification->id);
                        $req->reception_date = Carbon::now();
                        $req->notif_id = $result1['results'][0]['message_id'];
                        $req->status = 1;
                        $req->order_id = $order->id;
                        $req->receiver_id = $order->client_userid;
                        $req->save();

                        $payment = new Payment();
                        $payment->identifier = $data->{'identifier'};
                        $payment->tx_reference = $data->{'tx_reference'};
                        $payment->payment_reference = $data->{'payment_reference'};
                        $payment->status = 0;
                        $date = $data->{'datetime'};
                        $payment->date_payment = Carbon::parse($date)->toDateTimeString();
                        $payment->order_amount = $data->{'amount'};
                        $payment->paymentmode_title = $data->{'payment_method'};
                        $payment->telephone = $input['phone'];
                        $payment->description = $input['description'];
                        
                        $payment->order_id = $input['order_id'];
                        
                        $payment->order_code = $order->order_code;
                        $payment->order_service = $order->service_title;

                        $payment->client_userid = $input['client_userid'];
                        $client = Client::where('user_id', $payment->client_userid)
                                            ->first();

                        $payment->client_id = $client->id;
                        $payment->client_name = $client->name;
                        $payment->client_firstname = $client->firstname;
                        $payment->client_email = $client->email;
                        $payment->client_address = $client->address;
                        $payment->client_phone = $client->phone_number;
                        $order->status = 2;

                        $payment->save();

                        $order->save();

                        $req1 = Notification::findOrFail($notification1->id);
                        $req1->delete();

                        return $this->sendResponse(new PaymentResource($payment), 'Paiement effectué avec succès.');

                    } elseif ($result2['success'] == 1) {

                        $req1 = Notification::findOrFail($notification1->id);
                        $req1->reception_date = Carbon::now();
                        $req1->notif_id = $result2['results'][0]['message_id'];
                        $req1->status = 1;
                        $req1->order_id = $order->id;
                        $req1->receiver_id = $order->collector_userid;
                        $req1->save();

                        $payment = new Payment();
                        $payment->identifier = $data->{'identifier'};
                        $payment->tx_reference = $data->{'tx_reference'};
                        $payment->payment_reference = $data->{'payment_reference'};
                        $payment->status = 0;
                        $date = $data->{'datetime'};
                        $payment->date_payment = Carbon::parse($date)->toDateTimeString();
                        $payment->order_amount = $data->{'amount'};
                        $payment->paymentmode_title = $data->{'payment_method'};
                        $payment->telephone = $input['phone'];
                        $payment->description = $input['description'];
                        
                        $payment->order_id = $input['order_id'];
                        
                        $payment->order_code = $order->order_code;
                        $payment->order_service = $order->service_title;

                        $payment->client_userid = $input['client_userid'];
                        $client = Client::where('user_id', $payment->client_userid)
                                            ->first();

                        $payment->client_id = $client->id;
                        $payment->client_name = $client->name;
                        $payment->client_firstname = $client->firstname;
                        $payment->client_email = $client->email;
                        $payment->client_address = $client->address;
                        $payment->client_phone = $client->phone_number;
                        $order->status = 2;

                        $payment->save();

                        $order->save();

                        $req = Notification::findOrFail($notification->id);
                        $req->delete();

                        return $this->sendResponse(new PaymentResource($payment), 'Paiement effectué avec succès.');
                        
                    }elseif (($result1['success'] == 0) && ($result2['success'] == 0)){

                        $req = Notification::findOrFail($notification->id);
                        $req->delete();
                        $req1 = Notification::findOrFail($notification1->id);
                        $req1->delete();

                        return $this->sendError('Error Payment!');
                    }

                    /*else {

                        return $this->sendError('Error Payment!');
                    } */



                }elseif($status == 2){
                    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                    $id = 0;

                    $notification = new Notification();

                    $order = Order::findOrFail($input['order_id']);

                    //$registrationIds = $request->registrationIds;
                    $user = User::findOrFail($request->client_userid);
                    $token = $user->firebase_token;

                    $user1 = User::findOrFail($order->collector_userid);
                    $token1 = $user1->firebase_token;
                    //dd($token);
                    $message = 'Votre paiement a été bien enregistré';
                    $message1 = 'Le paiement du client a été effectué avec succès';
                    $title = 'Notification de paiement';

                    $notification->message = $message;
                    $notification->title = $title;

                    $notification->save();
                    
                    $id = $notification->id;

                    $msg = array (
                        'message'=> $message,
                        'id'=> $id,
                        'title'=> $title,
                        'soundname'=> 'default',
                        'android_channel_id'=> 'dominion_channel',
                        'description' => 'dominion notification',
                        'type'=> 'CLOSE_COLLECT',
                        'object'=> $order,
                        'subtitle'=> null,
                        'tickerText'=> null,
                        'vibrate'=>1,
                        /*'sound'=>1,*/
                        'largeIcon'=>'large_icon',
                        'smallIcon'=>'small_icon'
                        );

                    $msg1 = array (
                        'message'=> $message1,
                        'id'=> $id,
                        'title'=> $title,
                        'soundname'=> 'default',
                        'android_channel_id'=> 'dominion_channel',
                        'description' => 'dominion notification',
                        'type'=> 'CLOSE_COLLECT',
                        'object'=> $order,
                        'subtitle'=> null,
                        'tickerText'=> null,
                        'vibrate'=>1,
                        /*'sound'=>1,*/
                        'largeIcon'=>'large_icon',
                        'smallIcon'=>'small_icon'
                        );
                    
                        $fields = array(//'registration_ids'=>$registrationIds,
                            'to'   => $token, //single token
                            'data' =>$msg
                        );

                        $fields1 = array(//'registration_ids'=>$registrationIds,
                            'to'   => $token1, //single token
                            'data' =>$msg1
                        );
                    
                        $headers = array ('Authorization: key=AAAA2D2MFi8:APA91bE9-OqL-BqZzq4evteuoNony8HLz4ee-1MzfKP368toxia9J_LctRrq9y83c3hI1v3oTwmBdP2S1eM-UZ-4prJlA3QJewyrqQHaHg272qg7FFDhVS6Hm1PUV9OAKkfdlOaP042B',
                        'Content-Type: application/json'
                        );
                
                        //curl client
                        $ch = curl_init();
                        curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
                        curl_setopt( $ch,CURLOPT_POST, true );
                        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
                        $result1 = curl_exec($ch);
                        curl_close($ch);
                        $result1 =  json_decode($result1, true);
                        
                        //curl collector
                        $ch1 = curl_init();
                        curl_setopt( $ch1,CURLOPT_URL, $fcmUrl);
                        curl_setopt( $ch1,CURLOPT_POST, true );
                        curl_setopt( $ch1,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch1,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch1,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode($fields1));
                        $result2 = curl_exec($ch1);
                        curl_close($ch1);
                        $result2 =  json_decode($result2, true);


                        if(($result1['success'] == 1) && ($result2['success'] == 1) ) {

                        $payment = new Payment();

                        $payment->order_id = $input['order_id'];
                        $payment->client_userid = $input['client_userid'];

                        $payment->identifier = $data->{'identifier'};

                        $payment->order_code = $order->order_code;
                        $payment->order_service = $order->service_title;
                        $payment->tx_reference = $data->{'tx_reference'};
                        $payment->payment_reference = $data->{'payment_reference'};
                        $payment->status = $data->{'status'};
                        $date = $data->{'datetime'};
                        $payment->date_payment = Carbon::parse($date)->toDateTimeString();
                        $payment->order_amount = $data->{'amount'};
                        $payment->paymentmode_title = $data->{'payment_method'};
                        $payment->telephone = $input['phone'];
                        $payment->description = $input['description'];
                
                        $client = Client::where('user_id', $payment->client_userid)
                                            ->first();

                        $payment->client_id = $client->id;
                        $payment->client_name = $client->name;
                        $payment->client_firstname = $client->firstname;
                        $payment->client_email = $client->email;
                        $payment->client_address = $client->address;
                        $payment->client_phone = $client->phone_number;
                        $order->status = 2;

                        $payment->save();

                        $order->save();

                        return $this->sendResponse(new PaymentResource($payment), 'Paiement en cours.');

                    } else {

                        return $this->sendError('Error Payment!');
                    } 
                 
                
                }elseif($status == 4){
                    //Payment::where('id', $payment->id)->delete();
                    $response = [
                        'success' => false,
                        'data'    => [],
                        'message' =>'Paiement expiré!',
                    ];
                    return response()->json($response, 200); 
                
                }elseif($status == 6){
                    //Payment::where('id', $payment->id)->delete();
                    $response = [
                        'success' => false,
                        'data'    => [],
                        'message' =>'Paiement annulé!',
                    ];
                    return response()->json($response, 200); 
                }
            
            
	    }
    }


    public function verify(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order = Order::findOrFail($request->order_id);

        $send = [
            'auth_token' => 'a81d1e51-bf4c-4fa1-ad94-ef30eb442c58',
            'identifier' => $order->identifier,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://paygateglobal.com/api/v2/status"            ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($send),
        CURLOPT_HTTPHEADER => array(
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
        ),
    ));

    $result = curl_exec($curl);
    $error = curl_error($curl);

    curl_close($curl);

        if ($error) {
            return $this->sendError('cURL Error #: '.$error);
            //echo "cURL Error #:" . $err;
        }else{
            $data = json_decode($result);
            $status = $data->{'status'};

            if($status == 0){

                $response = [
                    'success' => true,
                    'data'    => [],
                    'message' =>'Paiement effectué avec succès!',
                ];
                return response()->json($response, 200); 

            }elseif($status == 2){
                
                $response = [
                    'success' => true,
                    'data'    => [],
                    'message' =>'Paiement en cours!',
                ];
                return response()->json($response, 200); 

            }elseif($status == 4){

                $response = [
                    'success' => false,
                    'data'    => [],
                    'message' =>'Paiement expiré!',
                ];
                return response()->json($response, 200); 
                
            }elseif($status == 6){

                $response = [
                    'success' => false,
                    'data'    => [],
                    'message' =>'Paiement annulé!',
                ];
                return response()->json($response, 200); 
            }
        }

    }

    public function payonline(Request $request)
    {
        $data = $request->all();
   
        $validator = Validator::make($data, [
            'order_id' => 'required',
            'client_userid' => 'required',
            'status' => 'required',
            'identifier' => 'required',
            'tx_reference' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        //$tx_reference = $parsed_json->{'tx_reference'};
        //$payment_reference = $parsed_json->{'payment_reference'};
        

        if($data['status']){

            $payment = Payment::where('identifier', $data['identifier'])->first();

            $payment->order_id = $data['order_id'];
            $order = Order::findOrFail($payment->order_id);
            $payment->order_code = $order->order_code;
            $payment->order_service = $order->service_title;
            $payment->tx_reference = $data['tx_reference'];
            $payment->status = $data['status'];
            $payment->description = $data['description'];

            $payment->client_userid = $data['client_userid'];
    
            $client = Client::where('user_id', $payment->client_userid)
                                ->first();

            $payment->client_id = $client->id;
            $payment->client_name = $client->name;
            $payment->client_firstname = $client->firstname;
            $payment->client_email = $client->email;
            $payment->client_address = $client->address;
            $payment->client_phone = $client->phone_number;
            $order->status = 2;
            //$payment->status = 1;

            $payment->save();
            $order->save();

            return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
 
        }else {

            return $this->sendError('Unauthorised.', ['error'=>'Error Payment!Retry again']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$payment = Payment::find($id);
        $payment = auth()->user()->mypayments()->find($id);
  
        if (is_null($payment)) {
            return $this->sendError('Payment not found.');
        }
   
        return $this->sendResponse(new PaymentResource($payment), 'Payment retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
   
        return $this->sendResponse([], 'Payment deleted successfully.');
    }

    public function generateIdentifier()
    {
        //$randomString = str_random(25);

        //$uniqid = Str::random(9);

        $uniqid = $this->unique_code(9);

        $response = [
            'success' => true,
            'identifier'    => $uniqid,
            'message' =>'Identifier retreive successfully!',
        ];
        return response()->json($response, 200);
    }

    public function getIdentifier(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order = Order::findOrFail($input['order_id']);

        $response = [
            'success' => true,
            'identifier'    => $order->identifier,
            'message' =>'Order identifier retreive successfully!',
        ];

        return response()->json($response, 200);
    }


    public function postIdentifier(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'order_id' => 'required',
            'identifier' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order = Order::findOrFail($input['order_id']);
        $order->identifier = $request->identifier;
        $order->save();

        $response = [
            'success' => true,
            'data'    => $order,
            'message' =>'Order identifier add successfully!',
        ];

        return response()->json($response, 200);
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
