<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Alert;
use App\User;
use App\Service;
use App\Client;
use App\CodePromo;
use App\Collector;
use App\Order;
use App\KiloPrice;
use App\Article;
use App\DepositedArticle;
use App\DeliveryHour;
use App\Delivery;
use App\CheckedArticle;
use App\Status;
use App\Http\Resources\Order as OrderResource;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->mypendingorders();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');
    }

    //Historique des commandes d'un client

    public function myorders()
    {
        $orders = auth()->user()->myorders();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');
    }

    //Commandes assignées à un collecteur

    public function mypendingcollects()
    {
        $orders = auth()->user()->pendingorders();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');
    }

    //Historique des commandes collectées par un collecteur

    public function myorderscollects()
    {
        $orders = auth()->user()->mycollectorders();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');

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

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
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
            'service_id' => 'required',
            'client_userid' => 'required',
            'meeting_place' => 'nullable',
            'place_delivery' => 'nullable',
            'code_promo' => 'nullable',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        //$order = Order::create($input);
        $order = new Order();
        if (isset($input['code_promo'])) {
            $order->code_promo = $request->code_promo;
        }
        $order->order_code = 'DOMINION-00';
        $order->service_id = $request->service_id;
        $service = Service::findOrFail($order->service_id);
        $order->service_title = $service->title;
        $order->order_amount = 0;
        $order->meeting_place = $request->meeting_place;
        $order->meeting_longitude = $request->meeting_longitude;
        $order->meeting_latitude  = $request->meeting_latitude;
        $order->delivery_longitude = $request->delivery_longitude;
        $order->delivery_latitude = $request->delivery_latitude;
        $order->place_delivery = $request->place_delivery;
        $order->client_userid = $request->client_userid;

        $client = Client::where('user_id', $order->client_userid)
                            ->first();

        $order->client_id = $client->id;
        $order->client_name = $client->name;
        $order->client_firstname = $client->firstname;
        $order->client_email = $client->email;
        $order->client_address = $client->address;
        $order->client_phone= $client->phone_number;
        $order->status = 0;
        //$order->amount_paid = 0;
        $order->total_net = 0;
        $order->discount = 0;
        //$order->left_pay = 0;
        $order->percentage = 0;
        $order->save();

        $orderFinal = Order::findOrFail($order->id);
        $orderFinal->order_code = $orderFinal->order_code.$order->id;
        $orderFinal->save();

        $users = User::where('role_id', 3)->get();
        
        foreach ($users as $user) {
            # code...
            $alert = new Alert();
            $alert->sender_id = $order->client_userid;
            $alert->body = "Le client $order->client_name $order->client_firstname a fait une demande de prestation pour un service de $order->service_title";
            $alert->route = route('orders.show', $order->id);
            $alert->status = 0;
            $alert->receiver_id = $user->id;
            $alert->save();
        }
   
        return $this->sendResponse(new OrderResource($order), 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
  
        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }

        $user = User::findOrFail($order->client_userid);
        
        if($order->collector_userid != ''){

           $user1 = User::findOrFail($order->collector_userid); 

           $order['collector_profile_picture'] = $user1->profile_picture;

        }else{
            $order['collector_profile_picture'] = '';
        }
        
        $order['client_profile_picture'] = $user->profile_picture;

        $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                               ->get();

        $order['depositedarticles'] = $depositedarticles;

        return $this->sendResponse($order, 'Order retrieved successfully.');
   
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

    public function updateCollect(Request $request, Order $order)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required',
            'code_promo' => 'nullable'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());      
        }
 
            $i = 0;
            $qte = 0;
            $amount = 0;
            $total_net = 0;

            $action = $data['action'];

            $heure = DeliveryHour::where('id', 1)->first();

            if($action == 'repassage_price'){
                $order->action = 'Repassage';
                $heure_retrait = $heure->repassage_hour;
            }elseif($action == 'lavage_price'){
                $order->action = 'Nettoyage Express';
                $heure_retrait = $heure->express_hour;
            }elseif($action == 'nettoyage_price'){
                $order->action = 'Nettoyage et Repassage';
                $heure_retrait = $heure->lavage_hour;
            }

            $check = Carbon::now()->addHours($heure_retrait);

            if((date('N', strtotime($check)) >= 7)){
                $date = Carbon::parse($check);
                $order->delivery_date = $date->addDays(1);
            }else{
                $order->delivery_date = Carbon::parse($check);
            }
            
            $depositedarticles = $order->depositedarticles;
            
            if(!$depositedarticles->isEmpty()){
                
                foreach($depositedarticles as $depositedarticle){

                    $checkedarticles = $depositedarticle->checkedarticles;
    
                    if(!$checkedarticles->isEmpty()){
                        
                        DB::table('checked_articles')->where('deposited_article_id', $depositedarticle->id)->delete();
                    }
                }
                
                DB::table('deposited_articles')->where('order_id', $order->id)->delete();
            }

            if (isset($request['code_promo'])) {
                
                if($order->code_promo != ''){

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
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->unit_price  = $articledeposited->$action;
                    $depositedArticle->status = 0;
                
                    $depositedArticle->etat = '';
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    
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
                    
                    $total_net += $amount;
                    
                    $qte += $depositedArticle->quantity;
                    
                    $i++;

                }

                    $order->quantity = $qte;
                
                    $order->total_net = $total_net;
               
                    //$order->order_amount = ($total_net - $order->discount);
                    
                    $date = Carbon::parse($order->created_at)->toDateString();

                    $code_promo = CodePromo::where('title', $order->code_promo)
                                            ->where('begin_date','<=', $date)
                                            ->where('end_date','>=', $date)
                                            ->where('leftover', '>', 0)
                                            ->first(); 
                    if($code_promo){   

                        $order->codepromo_id = $code_promo->id;

                        $order->discount = ($code_promo->pourcentage/100) * $total_net;
                        
                        $order->percentage = $code_promo->pourcentage;

                        $order->order_amount = ($total_net - $order->discount);
            
                        $code_promo->leftover -= 1;

                        $code_promo->save();

                    }else{
                        $order->discount = 0;
                        
                        $order->percentage = 0;
                        
                        $order->order_amount = $total_net; 
                    }
                    
                    $order->status = 1;
                
                    $order->date_collect = Carbon::now();
    
                    $order->save();
                    
                    $orderFinal = Order::findOrFail($order->id);
                    
                    $orderFinal['depositedarticles'] = [];
    
                    $newdepositedarticles = DepositedArticle::where('order_id', $orderFinal->id)->get();
    
                    $orderFinal['depositedarticles'] = $newdepositedarticles;
    
                    return $this->sendResponse($orderFinal, 'Collect updated successfully .');

                    
                }else{

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
                        $customer = Client::findOrFail($depositedArticle->client_id);
                        $depositedArticle->client_name = $customer->name;
                        $depositedArticle->client_firstname = $customer->firstname;
                        $depositedArticle->client_userid = $customer->user_id;
                        $depositedArticle->user_id = $order->collector_userid;
                        $depositedArticle->article_title = $data['article_title'];
                        $depositedArticle->unit_price  = $articledeposited->$action;
                        $depositedArticle->status = 0;

                        $depositedArticle->etat = '';
                        
                        $depositedArticle->save();

                        $etats = $request['etats_'.$i]; //Retrieving the etats field
                        //Checking if a etat was selected
                        
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
                        $total_net += $amount;
                        $qte += $depositedArticle->quantity;
                        $i++;

                    }
                    
                    $order->total_net = $total_net;
                    
                    $order->code_promo = $request->code_promo;

                    $order->quantity = $qte;
                   
                    $date = Carbon::today()->toDateString();

                    $code_promo = CodePromo::where('title', $request->code_promo)
                                            ->where('begin_date','<=', $date)
                                            ->where('end_date','>=', $date)
                                            ->where('leftover', '>', 0)
                                            ->first(); 
                    if($code_promo){   

                        $order->codepromo_id = $code_promo->id;

                        $order->discount = ($code_promo->pourcentage/100) * $total_net;
                        
                        $order->percentage = $code_promo->pourcentage;

                        $order->order_amount = ($total_net - $order->discount);
            
                        $code_promo->leftover -= 1;

                        $code_promo->save();

                    }else{
                        $order->discount = 0;
                        
                        $order->percentage = 0;
                        
                        $order->order_amount = $total_net; 
                    }
                    
                    
                    $order->status = 1;
                
                    $order->date_collect = Carbon::now();
    
                    $order->save();
                    
                    $orderFinal = Order::findOrFail($order->id);
                    
                    $orderFinal['depositedarticles'] = [];
    
                    $newdepositedarticles = DepositedArticle::where('order_id', $orderFinal->id)->get();
    
                    $orderFinal['depositedarticles'] = $newdepositedarticles;
    
                    return $this->sendResponse($orderFinal, 'Collect updated successfully .');
                }

                
            }else{
                
                foreach($data['article_id'] as $article){

                    $articledeposited = Article::findOrFail($article);
    
                    $amount = $articledeposited->$action * $data['quantity'][$i];
                    $data['article_title'] = $articledeposited->title;
                    
                    $depositedArticle = new DepositedArticle();
        
                    $depositedArticle->article_id = $article;
                    $depositedArticle->designation = $data['designation'][$i];
                    $depositedArticle->quantity = $data['quantity'][$i];
                    $depositedArticle->tidy = $data['tidy'][$i];
                    $depositedArticle->amount = $amount;
                    $depositedArticle->order_id = $order->id;
                    $depositedArticle->client_id = $order->client_id;
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->unit_price  = $articledeposited->$action;
                    $depositedArticle->status = 0;
                
                    $depositedArticle->etat = '';
                    
                    $depositedArticle->save();

                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    
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
                    
                    $total_net += $amount;
                    
                    $qte += $depositedArticle->quantity;
                    
                    $i++;

                }

                $order->quantity = $qte;
                
                $order->discount = 0;
                
                $order->percentage = 0;
                
                $order->total_net = $total_net;
               
                $order->order_amount = $total_net;
                
                $order->status = 1;

                $order->date_collect = Carbon::now();

                $order->save();
                
                $orderFinal = Order::findOrFail($order->id);
                    
                $orderFinal['depositedarticles'] = [];

                $newdepositedarticles = DepositedArticle::where('order_id', $orderFinal->id)->get();

                $orderFinal['depositedarticles'] = $newdepositedarticles;

                return $this->sendResponse($orderFinal, 'Collect updated successfully .');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'service_id' => 'required',
            'client_userid' => 'required',
            'meeting_place' => 'nullable',
            'place_delivery' => 'nullable',
            'code_promo' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if($order->status == 0){
            if (isset($input['code_promo'])) {
                $order->code_promo = $request->code_promo;
            }
            $order->service_id = $request->service_id;
            $service = Service::findOrFail($order->service_id);
            $order->service_title = $service->title;
            $order->meeting_place = $request->meeting_place;
            $order->place_delivery = $request->place_delivery;
            $order->delivery_longitude = $request->delivery_longitude;
            $order->delivery_latitude = $request->delivery_latitude;
            $order->meeting_longitude = $request->meeting_longitude;
            $order->meeting_latitude  = $request->meeting_latitude; 
            $order->client_userid = $request->client_userid;

            $client = Client::where('user_id', $order->client_userid)
                                ->first();

            $order->client_id = $client->id;
            $order->client_name = $client->name;
            $order->client_firstname = $client->firstname;
            $order->client_email = $client->email;
            $order->client_address = $client->address;
            $order->client_phone= $client->phone_number;
            //$order->amount_paid = 0;
            $order->percentage = 0;
            //$order->left_pay = 0;
            $order->status = 0;
            $order->save();

            //return $this->sendResponse(new OrderResource($order), 'Order updated successfully.');
            return $this->sendResponse($order, 'Order updated successfully.');
        }else{
            return $this->sendError('This Order can not be updated.');
        }

        
    }


    public function makedetailcollect(Request $request, Order $order)
    { 
        $data = $request->all();
   
        $validator = Validator::make($data, [
            'action' => 'required',
            'code_promo' => 'nullable'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
            $i = 0;
            $qte = 0;
            $amount = 0;
            $total_net = 0;

            $action = $data['action'];

            $heure = DeliveryHour::where('id', 1)->first();

            if($action == 'repassage_price'){
                $order->action = 'Repassage';
                $heure_retrait = $heure->repassage_hour;
            }elseif($action == 'lavage_price'){
                $order->action = 'Nettoyage Express';
                $heure_retrait = $heure->express_hour;
            }elseif($action == 'nettoyage_price'){
                $order->action = 'Nettoyage et Repassage';
                $heure_retrait = $heure->lavage_hour;
            }

            $check = Carbon::now()->addHours($heure_retrait);

            if((date('N', strtotime($check)) >= 7)){
                $date = Carbon::parse($check);
                $order->delivery_date = $date->addDays(1);
            }else{
                $order->delivery_date = Carbon::parse($check);
            }

            if (isset($data['code_promo'])) {

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
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->unit_price  = $articledeposited->$action;
                    $depositedArticle->status = 0;
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    
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
                    $total_net += $amount;
                    $qte += $depositedArticle->quantity;
                    $i++;

                }
                
                $order->total_net = $total_net;

                $order->identifier = $this->unique_code(9);
                
                $order->code_promo = $request->code_promo;
                
                $order->quantity = $qte;
               
                $date = Carbon::now()->toDateString();

                $code_promo = CodePromo::where('title', $request->code_promo)
                                        ->where('begin_date','<=', $date)
                                        ->where('end_date','>=', $date)
                                        ->where('leftover', '>', 0)
                                        ->first(); 
                if($code_promo){   

                    $order->codepromo_id = $code_promo->id;
                    
                    $order->percentage = $code_promo->pourcentage;

                    $order->discount = ($code_promo->pourcentage/100) * $total_net;

                    $order->order_amount = ($total_net - $order->discount);
                    
                    //$order->left_pay = $order->order_amount;
        
                    $code_promo->leftover -= 1;
                    
                    $code_promo->save();

                }else{
                    $order->order_amount = $total_net; 
                    
                    //$order->left_pay = $order->order_amount;
                    
                    $order->discount = 0;
                    
                    $order->percentage = 0;
                }

                $order->status = 1;
                
                $order->date_collect = Carbon::now();

                $order->save();
                
                $order['depositedarticles'] = [];
                
                $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                                   ->get();

                $order['depositedarticles'] = $depositedarticles;

                return $this->sendResponse($order, 'Collect successfully recorded.');

            }else{
                
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
                    $customer = Client::findOrFail($depositedArticle->client_id);
                    $depositedArticle->client_name = $customer->name;
                    $depositedArticle->client_firstname = $customer->firstname;
                    $depositedArticle->client_userid = $customer->user_id;
                    $depositedArticle->user_id = $order->collector_userid;
                    $depositedArticle->article_title = $data['article_title'];
                    $depositedArticle->unit_price  = $articledeposited->$action;
                    $depositedArticle->status = 0;
                    
                    $depositedArticle->save();
        
                    $etats = $request['etats_'.$i]; //Retrieving the etats field
                    //Checking if a etat was selected
                    
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
                    $total_net += $amount;
                    $qte += $depositedArticle->quantity;
                    $i++;

                }
                
                $order->total_net = $total_net;

                $order->identifier = $this->unique_code(9);
                
                $order->quantity = $qte;

                if($order->code_promo != ''){
                            $date = Carbon::parse($order->created_at)->toDateString();
                            //$date1 = $date->format('Y-m-d');
                            $code_promo = CodePromo::where('title', $order->code_promo)
                                                    ->where('begin_date','<=', $date)
                                                    ->where('end_date','>=', $date)
                                                    ->where('leftover', '>', 0)
                                                    ->first(); 
                    if($code_promo){   

                        $order->codepromo_id = $code_promo->id;
                        
                        $order->discount = ($code_promo->pourcentage/100) * $total_net;
                        
                        $order->percentage = $code_promo->pourcentage;
                        
                        $order->order_amount = ($total_net - $order->discount);
                        
                        //$order->left_pay = $order->order_amount;
            
                        $code_promo->leftover -= 1;
                        
                        $code_promo->save();

                    }else{
                        
                        $order->order_amount = $total_net; 
                        
                        //$order->left_pay = $order->order_amount;
                        
                        $order->discount = 0;
                        
                        $order->percentage = 0;
                    }

                }else{
                    
                    $order->order_amount = $total_net;
                    
                    //$order->left_pay = $order->order_amount;
                    
                    $order->discount =  0;
                    
                    $order->percentage = 0;
                }

                $order->status = 1;

                $order->date_collect = Carbon::now();

                $order->save();
                
                $order['depositedarticles'] = [];

                $depositedarticles = DepositedArticle::where('order_id',$order->id)
                                                   ->get();

                $order['depositedarticles'] = $depositedarticles;
        
                return $this->sendResponse($order, 'Collect successfully recorded.');

            }
           
    }
    
   public function updatePlace(Request $request, Order $order)
    { 
        $data = $request->all();
   
        $validator = Validator::make($data, [
            'place_delivery' => 'nullable',
            'delivery_longitude' => 'nullable',
            'delivery_latitude' => 'nullable'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $order->place_delivery = $request->place_delivery;
        
        $order->delivery_longitude = $request->delivery_longitude;
        
        $order->delivery_latitude = $request->delivery_latitude;
        
        $delivery = Delivery::where('order_id', $order->id)->first();
        
        if($delivery){
            
            $delivery->place_delivery = $request->place_delivery;
        
            $delivery->delivery_longitude = $request->delivery_longitude;
        
            $delivery->delivery_latitude = $request->delivery_latitude;
        
            $delivery->save();
        }
        
        $order->save();
        
        return $this->sendResponse($order, 'Delivery place updated successfully .');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order->status == 0){

            $order->delete();
   
            return $this->sendResponse([], 'Order cancelled successfully.');
        }else{
            return $this->sendError('This Order can not be cancelled.');
        }
    }
}
