<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Delivery as DeliveryResource;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Collector;
use App\User;
use App\Notification;
use App\Order;
use App\Delivery;
use App\DepositedArticle;

class DeliveryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = auth()->user()->mypendingdeliveries();

        //return $this->sendResponse(DeliveryResource::collection($deliveries), 'Deliveries retrieved successfully.');
        return $this->sendResponse($deliveries, 'Deliveries retrieved successfully.');
    }

    //Historique des commandes d'un client

    public function mydeliveries()
    {
        $deliveries = auth()->user()->mydeliveries();

        return $this->sendResponse(DeliveryResource::collection($deliveries), 'Deliveries retrieved successfully.');
    }

    //Commandes assignées à un collecteur

    public function mypendingcollects()
    {
        $deliveries = auth()->user()->pendingdeliveries();

        //return $this->sendResponse(DeliveryResource::collection($deliveries), 'Deliveries retrieved successfully.');
        
        return $this->sendResponse($deliveries, 'Deliveries retrieved successfully.');
    }

    //Historique des commandes collectées par un collecteur

    public function mycloseddeliveries()
    {
        $deliveries = auth()->user()->mycloseddeliveries();

        //return $this->sendResponse(DeliveryResource::collection($deliveries), 'Deliveries retrieved successfully.');
        return $this->sendResponse($deliveries, 'Deliveries retrieved successfully.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'delivery_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        
        $delivery = Delivery::findOrFail($request->delivery_id);

        $order = Order::findOrFail($delivery->order_id);

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = new Notification();
        
        $user = User::findOrFail($delivery->client_userid);
        
        $token = $user->firebase_token;
        
        $message_FR = 'Votre livraison a été effectuée avec succès. Merci pour votre confiance!';
        
        $message_EN = 'Your delivery has been successfully completed. Thank you for your trust!';
        
        $title_FR = 'Notification de livraison';
        
        $title_EN = 'Delivery notification';
        
        if($user->lang == 'FR'){
            $notification->message = $message_FR;
            $notification->title = $title_FR;
        }else{
            $notification->message = $message_EN;
            $notification->title = $title_EN;
        }
        
        $notification->save();

        $msg = array (
        'message'=> $notification->message,
        'id'=> $notification->id,
        'title'=> $notification->title,
        'soundname'=> 'default',
        'android_channel_id'=> 'dominion_channel',
        'description' => 'dominion notification',
        'type'=> 'CLOSE_DELIVERY',
        'object'=> $delivery,
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
    
        $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
        'Content-Type: application/json'
        );
    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close( $ch );
        $result =  json_decode($result, true);


        if ($result['success'] == 1) {
            
            $req = Notification::findOrFail($notification->id);
            $req->reception_date = Carbon::now();
            $req->notif_id = $result['results'][0]['message_id'];
            $req->order_id = $order->id;
            $req->delivery_id = $delivery->id;
            $req->status = 1;
            $req->save();

            $delivery->status = 1;
            $order->status = 2;

            //return $this->sendResponse(new DeliveryResource($delivery), 'Delivery closed successfully.');
            return $this->sendResponse($delivery, 'Delivery closed successfully.');

        } else {

            return $this->sendError('Validation Error.', $validator->errors());   
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
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $depositedarticles = DepositedArticle::where('order_id', $delivery->order_id)
                                               ->get();

        $user = User::findOrFail($delivery->client_userid);

        if($delivery->collector_userid != ''){

           $user1 = User::findOrFail($delivery->collector_userid); 

           $delivery['collector_profile_picture'] = $user1->profile_picture;

        }else{
            $delivery['collector_profile_picture'] = '';
        }
        
        $delivery['client_profile_picture'] = $user->profile_picture;

        $delivery['depositedarticles'] = $depositedarticles;
   
        return $this->sendResponse($delivery, 'Delivery retrieved successfully.');
   
        //return $this->sendResponse(new DeliveryResource($delivery), 'Delivery retrieved successfully.');
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
    public function update(Request $request, Delivery $delivery)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'delivery_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order = Order::findOrFail($delivery->order_id);

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
       
        $notification = new Notification();
        
        $notification1 = new Notification();
        
        $user = User::findOrFail($delivery->client_userid);
        
        $token = $user->firebase_token;

        $user1 = User::findOrFail($delivery->collector_userid);
        
        $token1 = $user1->firebase_token;
        
        $message1 = 'Votre livraison est bien enregistré clôturée';
        
        $message_FR = 'Cette livraison a été clôturée avec succès. Merci pour votre confiance';
        
        $message_EN = 'This delivery was successfully completed. Thank you for your trust';
        
        $title_FR = 'Notification de clôture de livraison';
        
        $title_EN = 'Delivery close notification';
        
        $title1 = 'Notification de clôture de livraison';

        if($user->lang == 'FR'){
            $notification->message = $message_FR;
            $notification->title = $title_FR;
        }else{
            $notification->message = $message_EN;
            $notification->title = $title_EN;
        }
        
        $notification1->message = $message1;
        $notification1->title = $title1;

        $notification->save();
        $notification1->save();

        $msg = array (
            'message'=> $notification->message,
            'id'=> $notification->id,
            'title'=> $notification->title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_DELIVERY',
            'object'=> $delivery,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'soundname'=>'notif',
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );
            
        $msg1 = array (
            'message'=> $notification1->message,
            'id'=> $notification1->id,
            'title'=> $notification1->title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'CLOSE_DELIVERY',
            'object'=> $delivery,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'soundname'=>'notif',
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
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
            $result = curl_exec($ch);
            curl_close( $ch );
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


            if (($result['success'] == 1) && ($result1['success'] == 1)) {
                
                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req->receiver_id = $delivery->client_userid;
                $req->status = 1;
                $req->save();
                
                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req1->receiver_id = $delivery->collector_userid;
                $req1->save();

                $delivery->status = 1;
                $order->status = 2;

                $delivery->save();
                $order->save();

                return $this->sendResponse(new DeliveryResource($delivery), 'Delivery closed successfully.');

            } elseif($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req->receiver_id = $delivery->client_userid;
                $req->save();

                $delivery->status = 1;
                $order->status = 2;

                $delivery->save();
                $order->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();

                return $this->sendResponse(new DeliveryResource($delivery), 'Delivery closed successfully.');

            } elseif($result1['success'] == 1) {

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req1->receiver_id = $delivery->collector_userid;
                $req1->save();

                $delivery->status = 1;
                $order->status = 2;

                $delivery->save();
                $order->save();

                $req = Notification::findOrFail($notification->id);
                $req->delete();

                return $this->sendResponse(new DeliveryResource($delivery), 'Delivery closed successfully.');
                
            } elseif(($result['success'] == 0) && ($result1['success'] == 0)) {

                $req = Notification::findOrFail($notification->id);
                $req->delete();
                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();

                $delivery->status = 1;

                $order->status = 2;

                $delivery->save();
                
                $order->save();

                return $this->sendResponse(new DeliveryResource($delivery), 'Delivery closed successfully.');
                
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
