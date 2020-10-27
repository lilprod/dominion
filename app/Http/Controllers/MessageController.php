<?php

namespace App\Http\Controllers;

use App\Helpers\Sms;
use Illuminate\Http\Request;
use App\Client;
use \Osms\Osms;

class MessageController extends Controller
{


    public function create($id)
    {
        $title = 'Nouveau message';
        $client = Client::findOrFail($id);
        $name = $client->name.' '.$client->firstname;

        return view('notifications.message', compact('title', 'id', 'name', 'client'));
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|numeric',
            'message' => 'required|max:255',
        ]);

       //$this->sendSMS($request['phone_number'], $request['message']);
       
        $config = array(
            'clientId' => 'VPZb3ew2KWoqo4PGcnSwN90JPidGAgkF',
            'clientSecret' => 'CGRaHAhk05NTxpeB'
        );
        
        $osms = new Osms($config);
        
        // retrieve an access token
        //$data = $osms->getTokenFromConsumerKey();
        
        /*$token = array(
            'token' => $data['access_token']
        );*/
        
        $response = $osms->getTokenFromConsumerKey();
       
       if (!empty($response['access_token'])) {
    
            $respons = $osms->sendSms(
                // sender
                    'tel:+224621111180',
                    // receiver
                    'tel:+'.$request['phone_number'],
                    $request['message'],
                   'Pressing Dominion'
                );
                
            //return $respons;
            return redirect(route('totake'))->with('success', 'Message bien envoyé!');
        }else{
            return redirect(route('totake'))->with('error', 'Message non envoyé!');
        }
        
        //return $answer;
        //return redirect(route('totake'));
    }

    public function sendSMS($phone, $message)
    {
        /*$config = array(
            'clientId' => config('app.clientId'),
            'clientSecret' =>  config('app.clientSecret'),
        );

        $osms = new Sms($config);

        $data = $osms->getTokenFromConsumerKey();*/
        
        $config = array(
            'clientId' => 'VPZb3ew2KWoqo4PGcnSwN90JPidGAgkF',
            'clientSecret' => 'CGRaHAhk05NTxpeB'
        );
        
        $osms = new Osms($config);
        
        // retrieve an access token
        $data = $osms->getTokenFromConsumerKey();
        $token = array(
            'token' => $data['access_token']
        );


        $response = $osms->sendSms(
        // sender
            'tel:+224621111180',
            // receiver
            //'tel:+224' . $phone,
            'tel:+' .$phone,
            // message
            $message,
            'Pressing Dominion'
        );
    }
}