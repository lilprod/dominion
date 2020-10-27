<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Collector;
use App\Client;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
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
        $notifications = Notification::orderBy('id', 'DESC')
                                    ->get(); //Get all notifications

        return view('notifications.index')->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications.create');
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
            'title' => 'required|max:255',
            'message' => 'required',
            'audience_id' => 'required',
        ]);

        $id = 0;

        if($request->audience_id == 1){

            $registrationIds = User::where('firebase_token', '!=', '')
                                    ->where('role_id', 1)
                                    ->get();

            foreach ($registrationIds as $key => $value) {

                $notification = new Notification();
                $notification->message = $request->message;
                $notification->title = $request->title;
        
                $notification->save();

                $this->notification($value->firebase_token, $request->title, $request->message, $notification->id, $value->id);

            }

        }elseif($request->audience_id == 2){
            
            $registrationIds = User::where('firebase_token', '!=', '')
                                    ->where('role_id', 2)
                                    ->get();

            foreach ($registrationIds as $key => $value) {
                
                $notification = new Notification();
                $notification->message = $request->message;
                $notification->title = $request->title;
        
                $notification->save();
              
                $this->notification($value->firebase_token, $request->title, $request->message, $notification->id, $value->id);
                
            }    

        }elseif($request->audience_id == 0){

            $registrationIds = User::where('firebase_token', '!=', '')
                                    ->whereNotIn('role_id', [3])
                                    ->get();

            foreach ($registrationIds as $key => $value) {
                
                
                $notification = new Notification();
                $notification->message = $request->message;
                $notification->title = $request->title;
        
                $notification->save();
                
                $this->notification($value->firebase_token, $request->title, $request->message, $notification->id, $value->id);

            }
        }

       //Redirect to the notifications.index view and display message
       return redirect()->route('notifications.index')
       ->with('success','Notification envoyée à l\'audience ciblée avec succès.'); 

    }

    public function notification($token, $title, $message, $id, $receiver_id)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        //$token = $token;

        $msg = array (
        'message'=> $message,
        'id'=> $id,
        'title'=> $title,
        'soundname'=> 'default',
        'android_channel_id'=> 'dominion_channel',
        'description' => 'dominion notification',
        'type'=> 'MESSAGE_DIFFUSION',
        'subtitle'=> null,
        'tickerText'=> null,
        'vibrate'=>1,
        /*'sound'=>1,*/
        'largeIcon'=>'large_icon',
        'smallIcon'=>'small_icon'
        );

        $fields = array
        ('to'=> $token,
         'data'=> $msg
        );
        
        $headers = [
            'Authorization: key=AAAAx8CTMhk:APA91bFDtWswz9Oi_pXrZxe1FSHugmwJ-S1ft9rUcEjMyvRxMWaOP1N8A5Uj92sY6aKEc8Uqq18Iqf5UjftA4V8AOOd_tGKEVMBCCsBxN2OUANtyQfT-Iu5CPu3ybADrVozRrKnkzxH3',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $result =  json_decode($result, true);
        //dd($result);

        if ($error) {
            return $error;
            //echo "cURL Error #:" . $err;
        }else{
            
            $req = Notification::find($id);
            $req->reception_date = Carbon::now();
            //$req->notif_id = $result['results'][0]['message_id'];
            $req->notif_id = $result['results'][0];
            $req->receiver_id = $receiver_id;
            $req->status = 1;
            $req->save();
        }

        return true;
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
