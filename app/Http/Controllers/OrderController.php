<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Collector;
use App\Notification;
use App\User;
use Carbon\Carbon;
use App\CheckedArticle;
use App\DepositedArticle;
use App\Alert;
use App\Service;
use App\Client;
use App\Payment;
use App\CodePromo;
use App\KiloPrice;
use App\Article;
use App\DeliveryHour;
use App\Status;
use App\Consommation;

class OrderController extends Controller
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
        $orders = Order::where('status', 0)
                        ->get(); //Get all orders

        return view('orders.index')->with('orders', $orders);
    }

    public function pending()
    {
        $orders = Order::where('status', 1)
                        ->get(); //Get all orders

        return view('orders.orders')->with('orders', $orders);
    }

    public function ordersTodeliver()
    {
        $orders = Order::where('status', 2)
                        ->get(); //Get all orders

        return view('orders.orderstodeliver')->with('orders', $orders);
    }

    public function assignCollector($id)
    {
        $order = Order::findOrFail($id); //Find order of id = $id

        $collectors = Collector::all()->pluck( 'full_name','id');

        return view('orders.ordertocollector', compact('order', 'collectors'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('orders.create');
    }


    public function kilodetail(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'order_id' => 'required',
        ]);

        $order = Order::findOrFail($request->order_id);

            $i = 0;
            $qte = 0;

            foreach($data['article_id'] as $article){

                    $articledeposited = Article::findOrFail($article);
    
                    //$amount = $articledeposited->$action * $data['quantity'][$i];
                    $data['article_title'] = $articledeposited->title ;
        
                    $depositedArticle = new DepositedArticle();
        
                    $depositedArticle->article_id = $article;
                    $depositedArticle->designation = $data['designation'][$i];
                    $depositedArticle->quantity = $data['quantity'][$i];
                    $depositedArticle->tidy = $data['tidy'][$i];
                    $depositedArticle->order_id = $order->id;
                    $depositedArticle->client_id = $order->client_id;
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->status = 0;
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    //if($i == 1) dd($etats);
                    
                     if (isset($etats)) {
                            //$items = $data['etats'][$j];
                            $data_etat = [];
                    
                            foreach($etats as $etat){
                                $new_etat = new CheckedArticle();
                                $etat_r = Status::where('id', '=', $etat)->firstOrFail();
                                $new_etat->order_id = $depositedArticle->order_id;
                                $new_etat->deposited_article_id = $depositedArticle->id;
                                $new_etat->status = $etat_r->title;
                                $new_etat->client_id = $depositedArticle->client_id;
                                $new_etat->client_name = $depositedArticle->client_name;
                                $new_etat->user_id = auth()->user()->id;
                                $new_etat->save();
                                $data_etat[] = $etat_r->title;
                                
                            }
                            
                            $et = implode(',', $data_etat);
                            
                            $depositedArticle = DepositedArticle::findOrFail($depositedArticle->id);
                            $depositedArticle->etat = $et;
                            $depositedArticle->save();
        
                    } 
                    $qte += $depositedArticle->quantity;
                    $i++;

                }

                $order->quantity = $qte;
                $order->save();

                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

                $notification = new Notification();

                $user = User::findOrFail($order->client_userid);

                $token = $user->firebase_token;
                
                $message_FR = 'Votre commande contient '.$order->quantity.' article(s) et est encours de traitement.';
        
                $message_EN = 'Your order contains '.$order-> quantity.' item (s) and is being processed.';
                
                $title_FR = 'Notification d\'étiquetage de commande';
                
                $title_EN = 'Order labeling notification';

                if($user->lang == 'FR'){
                    $notification->message = $message_FR;
                    $notification->title = $title_FR;
                }else{
                    $notification->message = $message_EN;
                    $notification->title = $title_EN;
                }

                $notification->save();

                $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                                   ->get();

                $order['depositedarticles'] = $depositedarticles;

                 $msg = array (
                    'message'=> $notification->message,
                    'id'=> $notification->id,
                    'title'=> $notification->title,
                    'soundname'=> 'default',
                    'android_channel_id'=> 'dominion_channel',
                    'description' => 'dominion notification',
                    'type'=> 'REPORTING_COMMANDE',
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

                $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
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

                if ($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $order->client_userid;
                $req->save();

                return redirect()->route('todeliver-orders')
                ->with('success','Commande '.$order->order_code.' étiquetée avec succès!');

                } else{

                    return redirect()->route('todeliver-orders')
                ->with('success','Commande '.$order->order_code.' étiquetée avec succès! Attention Notification non envoyée au Client');
                }

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

        // API access key from Google API's Console
        //define( 'API_ACCESS_KEY', 'AAAA2D2MFi8:APA91bE9-OqL-BqZzq4evteuoNony8HLz4ee-1MzfKP368toxia9J_LctRrq9y83c3hI1v3oTwmBdP2S1eM-UZ-4prJlA3QJewyrqQHaHg272qg7FFDhVS6Hm1PUV9OAKkfdlOaP042B' );

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
     
        $notification = new Notification();
        
        $notification1 = new Notification();

        //$registrationIds = $request->registrationIds;
        $user = User::findOrFail($collector->user_id);
        $token = $user->firebase_token;

        $user1 = User::findOrFail($order->client_userid);
        $token1 = $user1->firebase_token;
        
        //dd($token);
        $message = 'Une nouvelle commande vous a été assignée. Veuillez consulter vos commandes à collecter';
        $title = 'Assignation d\'une nouvelle commande';
        
        $message_FR = 'Un collecteur prendra attache avec vous dans les plus brefs délais pour la recupération de votre commande. Merci';
        
        $message_EN = 'A collector will contact you as soon as possible for the recovery of your order. Thanks!';
        
        $title_FR = 'Notification d\'envoi d\'un collecteur pour prise de commande';
        
        $title_EN = 'Notification of dispatch of a collector for order taking';

        $notification->message = $message;
        $notification->title = $title;

        if($user1->lang == 'FR'){
            $notification1->message = $message_FR;
            $notification1->title = $title_FR;
        }else{
            $notification1->message = $message_EN;
            $notification1->title = $title_EN;
        }

        $notification->save();
        $notification1->save();

        $msg = array (
            'message'=> $message,
            'id'=> $notification->id,
            'title'=> $title,
            'soundname'=> 'default',
            'android_channel_id'=> 'dominion_channel',
            'description' => 'dominion notification',
            'type'=> 'ASSIGN_COLLECT',
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
                'android_channel_id'=> 'dominion_channel',
                'description' => 'dominion notification',
                'type'=> 'ASSIGN_COLLECT',
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
            curl_setopt( $ch1,CURLOPT_POSTFIELDS, json_encode($fields1));
            $result1 = curl_exec($ch1);
            curl_close($ch1);
            $result1 =  json_decode($result1, true);

            //dd($result,$result1);

            if (($result['success'] == 1) && ($result1['success'] == 1)) {
                
                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $collector->user_id;
                $req->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->receiver_id = $order->client_userid;
                $req1->save();

                $order->collector_id = $collector->id;
                $order->collector_name = $collector->name;
                $order->collector_firstname = $collector->firstname;
                $order->collector_email = $collector->email;
                $order->collector_address = $collector->address;
                $order->collector_phone = $collector->phone_number;
                $order->collector_userid = $collector->user_id;
                $order->status = 1;
                        
                $order->save();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-orders')
                ->with('success',
                'Collecteur assigné à la commande '.$order->order_code.' avec succès.');
                
            } elseif ($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $collector->user_id;
                $req->save();

                $order->collector_id = $collector->id;
                $order->collector_name = $collector->name;
                $order->collector_firstname = $collector->firstname;
                $order->collector_email = $collector->email;
                $order->collector_address = $collector->address;
                $order->collector_phone = $collector->phone_number;
                $order->collector_userid = $collector->user_id;
                $order->status = 1;
                        
                $order->save();

                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-orders')->with('success','Collecteur assigné à la commande '.$order->order_code.' avec succès. Attention! Notification non envoyée au client');

            }elseif (($result1['success'] == 1)) {

                $req1 = Notification::findOrFail($notification1->id);
                $req1->reception_date = Carbon::now();
                $req1->notif_id = $result1['results'][0]['message_id'];
                $req1->status = 1;
                $req1->order_id = $order->id;
                $req1->receiver_id = $order->client_userid;
                $req1->save();

                $order->collector_id = $collector->id;
                $order->collector_name = $collector->name;
                $order->collector_firstname = $collector->firstname;
                $order->collector_email = $collector->email;
                $order->collector_address = $collector->address;
                $order->collector_phone = $collector->phone_number;
                $order->collector_userid = $collector->user_id;
                $order->status = 1;
                        
                $order->save();

                $req = Notification::findOrFail($notification->id);
                $req->delete();

                //Redirect to the notifications.index view and display message
                return redirect()->route('pending-orders')
                ->with('success','Collecteur assigné à la commande '.$order->order_code.' avec succès. Attention! Notification non envoyée au collecteur.');

            }elseif (($result['success'] == 0) && ($result1['success'] == 0)){

                $order->collector_id = $collector->id;
                $order->collector_name = $collector->name;
                $order->collector_firstname = $collector->firstname;
                $order->collector_email = $collector->email;
                $order->collector_address = $collector->address;
                $order->collector_phone = $collector->phone_number;
                $order->collector_userid = $collector->user_id;
                $order->status = 1;

                $req = Notification::findOrFail($notification->id);
                $req->delete();
                $req1 = Notification::findOrFail($notification1->id);
                $req1->delete();
                        
                $order->save();

                return redirect()->route('pending-orders')
                ->with('success','Collecteur assigné à la commande '.$order->order_code.' avec succès. Attention! Aucune Notification n\'a été envoyée.');
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

        $order = Order::findOrFail($id); //Find order of id = $id

        //$customer = Client::findOrFail($deposit->client_id);

         $depositedarticles = DepositedArticle::where('client_id', '=', $order->client_id)
                                                ->where('order_id', '=', $order->id)
                                                ->get(); 
                                                
        //$depositedarticles = $deposit->depositedarticles;
        //$taches = $order->checkedarticles;

        return view('orders.show', compact('order', 'depositedarticles', 'date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id); //Find order of id = $id

        $articles = Article::orderBy('title')->get();

        $etats = Status::get();

        $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                                   ->get();

        foreach ($depositedarticles as $depositedarticle) {
             # code...
            $checkedarticles = $depositedarticle->checkedarticles;
         } 
        

        return view('orders.edit', compact('order', 'articles','etats','depositedarticles','checkedarticles'));
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
        $data = $request->all();
        $this->validate($request, [
            'order_id' => 'required',
        ]);

        $order = Order::findOrFail($id);

            $i = 0;
            $qte = 0;

            foreach($data['article_id'] as $article){

                    $articledeposited = Article::findOrFail($article);
    
                    //$amount = $articledeposited->$action * $data['quantity'][$i];
                    $data['article_title'] = $articledeposited->title ;
        
                    $depositedArticle = DepositedArticle::findOrFail($data['depositedArticle_id'][$i]);
        
                    $depositedArticle->article_id = $article;
                    $depositedArticle->designation = $data['designation'][$i];
                    $depositedArticle->quantity = $data['quantity'][$i];
                    $depositedArticle->tidy = $data['tidy'][$i];
                    $depositedArticle->order_id = $order->id;
                    $depositedArticle->client_id = $order->client_id;
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->status = 0;

                    $depositedArticle->etat = '';
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i];
                    //Retrieving the etats field
                    //Checking if a etat was selected
                    //if($i == 1) dd($etats);

                    $checkedarticles = $depositedArticle->checkedarticles;

                    if(!$checkedarticles->isEmpty()){

                        CheckedArticle::where('deposited_article_id', $depositedArticle->id)->delete();
                    }

                     if (isset($etats)) {
                         
                            $data_etat = [];
                    
                            foreach($etats as $etat){

                                $new_etat = new CheckedArticle();
                                $etat_r = Status::where('id', '=', $etat)->firstOrFail();
                                $new_etat->order_id = $depositedArticle->order_id;
                                $new_etat->deposited_article_id = $depositedArticle->id;
                                $new_etat->status = $etat_r->title;
                                $new_etat->client_id = $depositedArticle->client_id;
                                $new_etat->client_name = $depositedArticle->client_name;
                                $new_etat->user_id = auth()->user()->id;
                                $new_etat->save();
                                $data_etat[] = $etat_r->title;
                                
                            }
                            
                            $et = implode(',', $data_etat);
                            
                            $depositedArticle = DepositedArticle::findOrFail($depositedArticle->id);
                            $depositedArticle->etat = $et;
                            $depositedArticle->save();
        
                    } 
                    $qte += $depositedArticle->quantity;
                    $i++;

                }

                $order->quantity = $qte;
                $order->save();

                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

                $notification = new Notification();

                $user = User::findOrFail($order->client_userid);

                $token = $user->firebase_token;
                
                $message_FR = 'Votre commande contient '.$order->quantity.' article(s) et est encours de traitement.';
        
                $message_EN = 'Your order contains '.$order-> quantity.' item (s) and is being processed.';
                
                $title_FR = 'Notification d\'étiquetage de commande';
                
                $title_EN = 'Order labeling notification';

                if($user->lang == 'FR'){
                    $notification->message = $message_FR;
                    $notification->title = $title_FR;
                }else{
                    $notification->message = $message_EN;
                    $notification->title = $title_EN;
                }

                $notification->save();
        
                $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                                   ->get();

                $order['depositedarticles'] = $depositedarticles;

                 $msg = array (
                'message'=> $notification->message,
                'id'=> $notification->id,
                'title'=> $notification->title,
                'soundname'=> 'default',
                'android_channel_id'=> 'dominion_channel',
                'description' => 'dominion notification',
                'type'=> 'REPORTING_COMMANDE',
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

                $headers = array ('Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
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

                if ($result['success'] == 1) {

                $req = Notification::findOrFail($notification->id);
                $req->reception_date = Carbon::now();
                $req->notif_id = $result['results'][0]['message_id'];
                $req->status = 1;
                $req->order_id = $order->id;
                $req->receiver_id = $order->client_userid;
                $req->save();

                return redirect()->route('todeliver-orders')
                ->with('success','Commande '.$order->order_code.' étiquetée avec succès!');

                } else{

                    return redirect()->route('todeliver-orders')
                ->with('success','Commande '.$order->order_code.' étiquetée avec succès! Attention Notification non envoyée au Client');
                }
    }

    public function findPrice(Request $request)
    {
        $price = $request->unit;
        $data = Article::select($price)->where('id', $request->id)->first();
        //dd($data);
        return $data->$price;

    }

    public function add($id)
    {
        $order = Order::findOrFail($id); //Find order of id = $id

        $articles = Article::orderBy('title')->get();

        $etats = Status::get();

        return view('orders.create', compact('articles', 'id','etats', 'order'));
    }
    
    public function recordOrder(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'service_id' => 'required',
            'client_id' => 'required',
            'amount_paid' => 'required',
            'action' => 'required',
            'weight' => 'nullable',
        ]);

        $client = Client::where('id', $request->client_id)
                            ->first();

        $order = new Order();

        $order->order_code = 'WASHMAN-00';

        $order->service_id = $request->service_id;

        $service = Service::findOrFail($order->service_id);

        $order->service_title = $service->title;

        $order->order_amount = 0;

        $order->client_userid = $client->user_id;

        $order->client_id = $client->id;

        $order->client_name = $client->name;

        $order->client_firstname = $client->firstname;

        $order->client_email = $client->email;

        $order->client_address = $client->address;

        $order->client_phone= $client->phone_number;

        $order->status = 0;
        
        $action = $data['action'];

        $heure = DeliveryHour::where('id', 1)->first();

        if($action == 'repassage_price'){
            $order->action = 'Repassage';
            $heure_retrait = $heure->repassage_hour;
        }elseif($action == 'lavage_price'){
            $order->action = 'Nettoyage Express';
            $heure_retrait = $heure->express_hour;
        }elseif($action == 'nettoyage_price'){
            $order->action = 'Nettoyage à sec';
            $heure_retrait = $heure->lavage_hour;
        }

        $check = Carbon::now()->addHours($heure_retrait);

        if((date('N', strtotime($check)) >= 7)){
            $date = Carbon::parse($check);
            $order->delivery_date = $date->addDays(1);
        }else{
            $order->delivery_date = Carbon::parse($check);
        }

        $order->save();

        $i = 0;
        $qte = 0;
        $amount = 0;
        $total_net = 0;

            foreach($data['article_id'] as $article){

                    $articledeposited = Article::findOrFail($article);
    
                    $amount = $articledeposited->$action * $data['quantity'][$i];
                    $data['article_title'] = $articledeposited->title ;
        
                    $depositedArticle = new DepositedArticle();
        
                    $depositedArticle->article_id = $article;
                    $depositedArticle->designation = $data['designation'][$i];
                    $depositedArticle->quantity = $data['quantity'][$i];
                    $depositedArticle->tidy = $data['tidy'][$i];
                    $depositedArticle->amount = $amount;
                    $depositedArticle->order_id = $order->id;
                    $depositedArticle->client_id = $order->client_id;
                    $depositedArticle->client_name = $client->name;
                    $depositedArticle->client_firstname = $client->firstname;
                    $depositedArticle->client_userid = $client->user_id;
                    $depositedArticle->user_id = auth()->user()->id;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->unit_price  = $articledeposited->$action;
                    $depositedArticle->status = 0;
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    
                     if (isset($etats)) {
                            //$items = $data['etats'][$j];
                            $data_etat = [];
                    
                            foreach($etats as $etat){
                                $new_etat = new CheckedArticle();
                                $etat_r = Status::where('id', '=', $etat)->firstOrFail();
                                $new_etat->order_id = $depositedArticle->order_id;
                                $new_etat->deposited_article_id = $depositedArticle->id;
                                $new_etat->status = $etat_r->title;
                                $new_etat->client_id = $depositedArticle->client_id;
                                $new_etat->client_name = $depositedArticle->client_name;
                                $new_etat->user_id = auth()->user()->id;
                                $new_etat->save();
                                $data_etat[] = $etat_r->title;
                                
                            }
                            
                            $et = implode(',', $data_etat);
                            
                            $depositedArticle = DepositedArticle::findOrFail($depositedArticle->id);
                            $depositedArticle->etat = $et;
                            $depositedArticle->save();
        
                    } 
                    $total_net += $amount;
                    $qte += $depositedArticle->quantity;
                    $i++;

                }

                $orderFinal = Order::findOrFail($order->id);

                $orderFinal->quantity = $qte;
            
                $orderFinal->order_amount = $total_net;
                
                $orderFinal->amount_paid = $request->amount_paid;
                
                $orderFinal->left_pay = ($orderFinal->order_amount - $orderFinal->amount_paid);
        
                $orderFinal->date_collect = Carbon::now();

                $orderFinal->order_code = $orderFinal->order_code.$order->id;

                $orderFinal->save();

                $payment = new Payment();
                $payment->order_id = $orderFinal->id;
                $payment->order_code = $orderFinal->order_code;
                $payment->order_service = $orderFinal->service_title;
                $payment->order_amount = $request->amount_paid;
                $payment->description = "Paiement de la commande $orderFinal->order_code";
                $payment->paymentmode_title = 'ESPECES';
                $payment->client_userid = $orderFinal->client_userid;
                $payment->client_id = $client->id;
                $payment->client_name = $client->name;
                $payment->client_firstname = $client->firstname;
                $payment->client_email = $client->email;
                $payment->client_address = $client->address;
                $payment->client_phone= $client->phone_number;
                $payment->telephone= $client->phone_number;

                $payment->collector_userid = auth()->user()->id;

                $user = User::findOrFail($payment->collector_userid);

                $payment->collector_id = $user->id;
                $payment->collector_name = $user->name;
                $payment->collector_firstname = $user->firstname;
                $payment->collector_email = $user->email;
                $payment->collector_address = $user->address;
                $payment->collector_phone = $user->phone_number;
                
                $orderFinal->collector_id = $user->id;
                $orderFinal->collector_name = $user->name;
                $orderFinal->collector_firstname = $user->firstname;
                $orderFinal->collector_email = $user->email;
                $orderFinal->collector_address = $user->address;
                $orderFinal->collector_phone = $user->phone_number;

                $payment->status = 1;

                $orderFinal->status = 2;

                $payment->save();

                $orderFinal->save();

                return redirect()->route('orders.show', $order->id);

    }
    
    public function doDeposit($id)
    {
        $customer = Client::findOrFail($id);

        $articles = Article::orderBy('title')->get();

        $name = $customer->name.' '.$customer->firstname;

        $etats = Status::get();
        
        $services = Service::get();

        return view('orders.dodeposit', compact('articles', 'id','etats', 'name', 'services'));
    }
    
    public function totake()
    {
        $date = Carbon::now()->toDateString();
        
        $orders = Order::where('delivery_date', '=', $date)
                            ->get();
        
        if ($orders) {
            return view('orders.answers', compact('orders'));
        }

        return view('orders.answers')->withMessage('error', 'Aucun retrait prévu pour aujourd\'hui!');
        
        //return view('orders.totake',compact('date'));
    }

    /*public function getTotake()
    {
        return view('orders.answers');
    }*/

    /*public function postTotake(Request $request)
    {
        $this->validate($request, [
            'date_totake' => 'required',
        ]);

        $date_totake = $request->input('date_totake');
        $deposits = Deposit::where('date_retrait', '=', $date_totake)
                            ->get();
        //return view('stats.answer', compact('deposits'));

        if ($deposits) {
            return view('stats.answers', compact('deposits'));
        }

        return view('stats.answers')->withMessage('error');
    }*/

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
