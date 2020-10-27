<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Collector;
use App\Client;
use App\Delivery;
use App\Notification;
use App\User;
use Carbon\Carbon;
use App\DepositedArticle;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']); //supAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('status', 1)
                        ->get(); //Get all deliveries

        return view('deliveries.index')->with('deliveries', $deliveries);
    }

    public function pending()
    {
        $deliveries = Delivery::where('status', 0)
                        ->get(); //Get all deliveries

        return view('deliveries.deliveries')->with('deliveries', $deliveries);
    }

    public function assignCollector($id)
    {
        $order = Order::findOrFail($id); //Find order of id = $id

        $collectors = Collector::all()->pluck( 'full_name','id');

        return view('deliveries.deliverytocollector', compact('order', 'collectors'));
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
        $this->validate($request, [
            'order_id' => 'required',
            'collector_id' => 'required',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        $collector = Collector::findOrFail($request->collector_id);

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = new Notification();
        
        $notification1 = new Notification();

        $user = User::findOrFail($collector->user_id);
        
        $token = $user->firebase_token;

        $user1 = User::findOrFail($order->client_userid);
        
        $token1 = $user1->firebase_token;
        
        //collecteur
        $message = 'Une nouvelle livraison vous a été assignée. Veuillez consulter vos commandes à livrer';
        
        $title = 'Assignation d\'une nouvelle livraison';

        $message_FR = 'Votre commande est prête.Un collecteur prendra attache avec vous dans les plus brefs délais pour la livraison de votre commande.Merci';
        
        $message_EN = 'Your order is ready and a collector will contact you as soon as possible for the delivery of your order. Thank you!';
        
        $title_FR = 'Notification d\'envoi d\'un collecteur pour livraison';
        
        $title_EN = 'Notification to send a collector for delivery';

        if($user->lang == 'FR'){
            $notification1->message = $message_FR;
            $notification1->title = $title_FR;
        }else{
            $notification1->message = $message_EN;
            $notification1->title = $title_EN;
        }

        $notification->message = $message;
        
        $notification->title = $title;

        $notification->save();
        
        $notification1->save();

        $msg = array (
            'message'=> $notification->message,
            'id'=> $notification->id,
            'title'=> $notification->title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'ASSIGN_DELIVERY',
            'object'=> $order,
            'subtitle'=> null,
            'tickerText'=> null,
            'vibrate'=>1,
            /*'sound'=>1,*/
            'largeIcon'=>'large_icon',
            'smallIcon'=>'small_icon'
            );

            $msg1 = array (
                'message'=> $notification1->message,
                'id'=> $notification1->id,
                'title'=> $notification1->title,
                'soundname'=> 'default',
                'android_channel_id'=> 'washman_channel',
                'type'=> 'ASSIGN_DELIVERY',
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
        
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch);
            curl_close( $ch );
            $result =  json_decode($result, true);


            $ch1 = curl_init();
            curl_setopt( $ch1,CURLOPT_URL, $fcmUrl);
            curl_setopt( $ch1,CURLOPT_POST, true );
            curl_setopt( $ch1,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch1,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch1,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode( $fields1 ) );
            $result1 = curl_exec($ch1);
            curl_close( $ch1 );
            $result1 =  json_decode($result1, true);

            if (($result['success'] == 1) && ($result1['success'] == 1)) {
                
                

                $delivery = new Delivery();

                $delivery->delivery_code = 'DOMINION-LIV-00';
                
                $delivery->order_id = $order->id;
                $delivery->order_code = $order->order_code;
                $delivery->service_id = $order->service_id;
                $delivery->service_title = $order->service_title;
                $delivery->action = $order->action;
                $delivery->order_amount = $order->order_amount;
                $delivery->amount_paid = $order->amount_paid;
                $delivery->left_pay = $order->left_pay;
                $delivery->total_net = $order->total_net;
                $delivery->percentage = $order->percentage;
                $delivery->quantity = $order->quantity;
                $delivery->weight = $order->weight;
        
                $date = Carbon::parse($order->created_at);
                //$date->format('H:i:s');
                $delivery->order_date = $date->format('Y-m-d');
        
                $delivery->delivery_date = $order->delivery_date;
                //$delivery->delivery_date = Carbon::now();
                $delivery->codepromo_id = $order->codepromo_id;
                $delivery->code_promo = $order->code_promo;
                $delivery->discount = $order->discount;
                $delivery->meeting_place = $order->meeting_place;
                $delivery->meeting_longitude = $order->meeting_longitude;
                $delivery->meeting_latitude = $order->meeting_latitude;
                $delivery->place_delivery = $order->place_delivery;
                $delivery->delivery_longitude = $order->delivery_longitude;
                $delivery->delivery_latitude = $order->delivery_latitude;
                $delivery->client_id = $order->client_id;
                $delivery->client_name = $order->client_name;
                $delivery->client_firstname = $order->client_firstname;
                $delivery->client_email = $order->client_email;
                $delivery->client_address = $order->client_address;
                $delivery->client_phone= $order->client_phone;
                $delivery->client_userid = $order->client_userid;

                $delivery->collector_id = $collector->id;
                $delivery->collector_name = $collector->name;
                $delivery->collector_firstname = $collector->firstname;
                $delivery->collector_email = $collector->email;
                $delivery->collector_address = $collector->address;
                $delivery->collector_phone = $collector->phone_number;
                $delivery->collector_userid = $collector->user_id;
                $delivery->status = 0;
                        
                $delivery->save();
        
                $deliveryFinal = Delivery::findOrFail($delivery->id);
                $deliveryFinal->delivery_code = $deliveryFinal->delivery_code.$delivery->id;
                $deliveryFinal->save();

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req->receiver_id = $collector->user_id;
                $req->status = 1;
                $req->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->delivery_id = $delivery->id;
                $req1->receiver_id = $order->client_userid;
                $req1->save();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-deliveries')
                ->with('success',
                'Collecteur assigné à la livraison '.$order->order_code.' avec succès.');
                
            } elseif ($result['success'] == 1) {

                
                $delivery = new Delivery();

                $delivery->delivery_code = 'DOMINION-LIV-00';
                
                $delivery->order_id = $order->id;
                $delivery->order_code = $order->order_code;
                $delivery->service_id = $order->service_id;
                $delivery->service_title = $order->service_title;
                $delivery->action = $order->action;
                $delivery->order_amount = $order->order_amount;
                $delivery->amount_paid = $order->amount_paid;
                $delivery->left_pay = $order->left_pay;
                $delivery->total_net = $order->total_net;
                $delivery->percentage = $order->percentage;
                $delivery->quantity = $order->quantity;
                $delivery->weight = $order->weight;
        
                $date = Carbon::parse($order->created_at);
                
                $delivery->order_date = $date->format('Y-m-d');
        
                $delivery->delivery_date = $order->delivery_date;
                
                $delivery->codepromo_id = $order->codepromo_id;
                
                $delivery->code_promo = $order->code_promo;
                
                $delivery->discount = $order->discount;
                $delivery->meeting_place = $order->meeting_place;
                $delivery->meeting_longitude = $order->meeting_longitude;
                $delivery->meeting_latitude = $order->meeting_latitude;
                $delivery->place_delivery = $order->place_delivery;
                $delivery->delivery_longitude = $order->delivery_longitude;
                $delivery->delivery_latitude = $order->delivery_latitude;
                $delivery->client_id = $order->client_id;
                $delivery->client_name = $order->client_name;
                $delivery->client_firstname = $order->client_firstname;
                $delivery->client_email = $order->client_email;
                $delivery->client_address = $order->client_address;
                $delivery->client_phone= $order->client_phone;
                $delivery->client_userid = $order->client_userid;

                $delivery->collector_id = $collector->id;
                $delivery->collector_name = $collector->name;
                $delivery->collector_firstname = $collector->firstname;
                $delivery->collector_email = $collector->email;
                $delivery->collector_address = $collector->address;
                $delivery->collector_phone = $collector->phone_number;
                $delivery->collector_userid = $collector->user_id;
                $delivery->status = 0;
                        
                $delivery->save();
        
                $deliveryFinal = Delivery::findOrFail($delivery->id);
                $deliveryFinal->delivery_code = $deliveryFinal->delivery_code.$delivery->id;
                $deliveryFinal->save();

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->order_id = $order->id;
                $req->delivery_id = $delivery->id;
                $req->receiver_id = $collector->user_id;
                $req->status = 1;
                $req->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();


                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-deliveries')
                ->with('success',
                'Collecteur assigné à la livraison '.$order->order_code.' avec succès. Attention! Notification non envoyé au client');

            }elseif (($result1['success'] == 1)) {

                $delivery = new Delivery();

                $delivery->delivery_code = 'DOMINION-LIV-00';
                
                $delivery->order_id = $order->id;
                $delivery->order_code = $order->order_code;
                $delivery->service_id = $order->service_id;
                $delivery->service_title = $order->service_title;
                $delivery->action = $order->action;
                $delivery->order_amount = $order->order_amount;
                $delivery->amount_paid = $order->amount_paid;
                $delivery->left_pay = $order->left_pay;
                $delivery->total_net = $order->total_net;
                $delivery->percentage = $order->percentage;
                $delivery->quantity = $order->quantity;
                $delivery->weight = $order->weight;
        
                $date = Carbon::parse($order->created_at);
                $delivery->order_date = $date->format('Y-m-d');
        
                $delivery->delivery_date = $order->delivery_date;
                $delivery->codepromo_id = $order->codepromo_id;
                $delivery->code_promo = $order->code_promo;
                $delivery->discount = $order->discount;
                $delivery->meeting_place = $order->meeting_place;
                $delivery->meeting_longitude = $order->meeting_longitude;
                $delivery->meeting_latitude = $order->meeting_latitude;
                $delivery->place_delivery = $order->place_delivery;
                $delivery->delivery_longitude = $order->delivery_longitude;
                $delivery->delivery_latitude = $order->delivery_latitude;
                $delivery->client_id = $order->client_id;
                $delivery->client_name = $order->client_name;
                $delivery->client_firstname = $order->client_firstname;
                $delivery->client_email = $order->client_email;
                $delivery->client_address = $order->client_address;
                $delivery->client_phone= $order->client_phone;
                $delivery->client_userid = $order->client_userid;

                $delivery->collector_id = $collector->id;
                $delivery->collector_name = $collector->name;
                $delivery->collector_firstname = $collector->firstname;
                $delivery->collector_email = $collector->email;
                $delivery->collector_address = $collector->address;
                $delivery->collector_phone = $collector->phone_number;
                $delivery->collector_userid = $collector->user_id;
                $delivery->status = 0;
                        
                $delivery->save();
        
                $deliveryFinal = Delivery::findOrFail($delivery->id);
                $deliveryFinal->delivery_code = $deliveryFinal->delivery_code.$delivery->id;
                $deliveryFinal->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->delivery_id = $delivery->id;
                $req1->receiver_id = $order->client_userid;
                $req1->save();

                $req = Notification::findOrFail($notification->id);
                $req->delete();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-deliveries')
                ->with('success',
                'Collecteur assigné à la livraison '.$order->order_code.' avec succès. Attention! Notification non envoyé au collecteur.');

            } elseif (($result['success'] == 0) && ($result1['success'] == 0)){
                

                $delivery = new Delivery();

                $delivery->delivery_code = 'DOMINION-LIV-00';
                
                $delivery->order_id = $order->id;

                $delivery->order_code = $order->order_code;
                $delivery->service_id = $order->service_id;
                $delivery->service_title = $order->service_title;
                $delivery->action = $order->action;
                $delivery->order_amount = $order->order_amount;
                $delivery->amount_paid = $order->amount_paid;
                $delivery->total_net = $order->total_net;
                $delivery->percentage = $order->percentage;
                $delivery->left_pay = $order->left_pay;
                $delivery->quantity = $order->quantity;
                $delivery->weight = $order->weight;
        
                $date = Carbon::parse($order->created_at);
                
                $delivery->order_date = $date->format('Y-m-d');
        
                $delivery->delivery_date = $order->delivery_date;
                
                $delivery->codepromo_id = $order->codepromo_id;
                
                $delivery->code_promo = $order->code_promo;
                
                $delivery->discount = $order->discount;
                $delivery->meeting_place = $order->meeting_place;
                $delivery->meeting_longitude = $order->meeting_longitude;
                $delivery->meeting_latitude = $order->meeting_latitude;
                $delivery->place_delivery = $order->place_delivery;
                $delivery->delivery_longitude = $order->delivery_longitude;
                $delivery->delivery_latitude = $order->delivery_latitude;
                $delivery->client_id = $order->client_id;
                $delivery->client_name = $order->client_name;
                $delivery->client_firstname = $order->client_firstname;
                $delivery->client_email = $order->client_email;
                $delivery->client_address = $order->client_address;
                $delivery->client_phone= $order->client_phone;
                $delivery->client_userid = $order->client_userid;

                $delivery->collector_id = $collector->id;
                $delivery->collector_name = $collector->name;
                $delivery->collector_firstname = $collector->firstname;
                $delivery->collector_email = $collector->email;
                $delivery->collector_address = $collector->address;
                $delivery->collector_phone = $collector->phone_number;
                $delivery->collector_userid = $collector->user_id;
                $delivery->status = 0;
                        
                $delivery->save();
        
                $deliveryFinal = Delivery::findOrFail($delivery->id);
                $deliveryFinal->delivery_code = $deliveryFinal->delivery_code.$delivery->id;
                $deliveryFinal->save();

                $req = Notification::findOrFail($notification->id);
                $req->delete();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-deliveries')
                ->with('success',
                'Collecteur assigné à la livraison '.$order->order_code.' avec succès. Attention! Aucune Notification n\'a été envoyé.');
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
        $date = Carbon::now();

        $delivery = Delivery::findOrFail($id); //Find deposit of id = $id

        $order = Order::findOrFail($delivery->order_id);

        $user = User::findOrFail($delivery->collector_userid);
        
        //$deposit->server = $user->name.' '.$user->firstname;
        
        $delivery->server = $user->firstname;

        $delivery->order_date = Carbon::parse($delivery->order_date);

        $depositedarticles = DB::table('deposited_articles')
             ->where('client_id', '=', $delivery->client_id)
             ->where('order_id', '=', $delivery->order_id)
             ->get();

        return view('deliveries.show', compact('delivery', 'depositedarticles', 'date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id); //Find delivery of id = $id

        return view('deliveries.edit', compact('delivery'));
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

    public function save(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'order_id'=> 'required',
            'left_pay' => 'required',
            'amount_paid' => 'required',
            //'discount' => 'required',
            //'order_amount' => 'required',
            //'date_depot' => 'required',
            //'date_retrait' => 'required',
        ]);

        $tmp = 0;
        $tmp1 = 0;
        $reste = 0;

        $tmp = $request->input('left_pay');

        $tmp1 = $request->input('amount_paid');

        $reste = $tmp - $tmp1;

        if($reste == 0){

        # code...
        
        $order = Order::findOrFail($request->order_id);

        $delivery = new Delivery();

        $delivery->delivery_code = 'DOMINION-LIV-00';
                
        $delivery->order_id = $order->id;

        $delivery->order_code = $order->order_code;

        $delivery->service_id = $order->service_id;

        $delivery->service_title = $order->service_title;

        $delivery->action = $order->action;

        $delivery->order_amount = $order->order_amount;

        $delivery->quantity = $request->input('quantity');

        //$delivery->amount_paid = $request->input('amount_paid');

        $delivery->amount_paid = $order->order_amount;

        //$delivery->quantity = $order->quantity;

        $delivery->weight = $order->weight;

        $date = Carbon::parse($order->created_at);
        //$date->format('H:i:s');
        $delivery->order_date = $date->format('Y-m-d');

        //$delivery->delivery_date = $order->delivery_date;
        $delivery->delivery_date = Carbon::now();

        $delivery->codepromo_id = $order->codepromo_id;

        $delivery->code_promo = $order->code_promo;

        $delivery->discount = $order->discount;

        $delivery->client_id = $order->client_id;

        $delivery->client_name = $order->client_name;

        $delivery->client_firstname = $order->client_firstname;

        $delivery->client_email = $order->client_email;

        $delivery->client_address = $order->client_address;

        $delivery->client_phone= $order->client_phone;

        $delivery->client_userid = $order->client_userid;

        $delivery->collector_id = auth()->user()->id;

        $user = User::findOrFail($delivery->collector_id);

        $delivery->collector_name = $user->name;

        $delivery->collector_firstname = $user->firstname;

        $delivery->collector_email = $user->email;

        $delivery->collector_address = $user->address;

        $delivery->collector_phone = $user->phone_number;

        $delivery->collector_userid = auth()->user()->id;

        $delivery->status = 1;

        $delivery->left_pay = 0;
                
        $delivery->save();
        
        /*$left_pay = $request->input('left_pay');

        $reste = $left_pay - $request->input('amount_paid');*/

        $delivery->left_pay = ($request->input('left_pay') - $request->input('amount_paid'));

        Order::where('id', $delivery->order_id)
                    ->update([
                            'status' => 2,
                            'left_pay' => 0,
                        ]);

        DepositedArticle::where('order_id', $delivery->order_id)
        ->update([
                'status' => 2,
            ]);

        $deliveryFinal = Delivery::findOrFail($delivery->id);
        $deliveryFinal->delivery_code = $deliveryFinal->delivery_code.$delivery->id;
        $deliveryFinal->save();

        //Redirect to the deliveries.index view and display message
        return redirect()->route('deliveries.show', $delivery->id)
            ->with('success',
             'Retrait effectué avec succès.');

        } else {

            return redirect()->route('delivery.create', $request->order_id)
            ->with('error',
             'Commande non soldée! Vous ne pouvez donc pas effectuer ce retrait.');

        }

    }

    public function add($id)
    {
        $order = Order::findOrFail($id);

        $date_now = Carbon::now()->toDateString();

        $date = $order->created_at->toDateString();

        return view('deliveries.create', compact('order', 'date', 'date_now'));
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
