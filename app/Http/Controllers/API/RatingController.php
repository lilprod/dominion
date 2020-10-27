<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Collector;
use App\Client;
use App\User;
use Validator;

class RatingController extends BaseController
{
    public function clientRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required',
            'rate' => 'nullable',
            'user_id' => 'required',
            'body' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $collector = Collector::find($request->collector_id);

        if (isset($request->rate)) {

            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rate;
            //$rating->user_id = auth()->user()->id;
            $rating->user_id = $request->user_id;
            $collector->ratings()->save($rating);

            $success = 'true';

            return $this->sendResponse($success, 'Customer feedback add successfully.');

        }elseif(isset($request->body)) {

            $comment = new Comment();
            $comment->collector_userid = $collector->user_id;

            $comment->client_id = $collector->id;
            $comment->client_name = $collector->name;
            $comment->client_firstname = $collector->firstname;
            $comment->client_email = $collector->email;
            $comment->client_address = $collector->address;
            $comment->client_phone= $collector->phone_number;
            $comment->status = 1;
            $comment->body = $request->body;
            $comment->user_id = $request->user_id;
            $user = User::findOrFail($comment->user_id);
            $comment->user_name = $user->name;
            $comment->user_firstname = $user->firstname;
            $comment->user_email = $user->email;
            $comment->user_address = $user->address;
            $comment->user_phone= $user->phone_number;

            $comment->save();

            $success = 'true';

            return $this->sendResponse($success, 'Customer feedback add successfully.');

        }elseif(isset($request->rate) && (isset($request->body))){

            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rate;
            //$rating->user_id = auth()->user()->id;
            $rating->user_id = $request->user_id;
            $collector->ratings()->save($rating);

            $comment = new Comment();
            $comment->collector_userid = $collector->user_id;

            $comment->client_id = $collector->id;
            $comment->client_name = $collector->name;
            $comment->client_firstname = $collector->firstname;
            $comment->client_email = $collector->email;
            $comment->client_address = $collector->address;
            $comment->client_phone= $collector->phone_number;
            $comment->status = 1;
            $comment->body = $request->body;
            $comment->user_id = $request->user_id;
            $user = User::findOrFail($comment->user_id);
            $comment->user_name = $user->name;
            $comment->user_firstname = $user->firstname;
            $comment->user_email = $user->email;
            $comment->user_address = $user->address;
            $comment->user_phone= $user->phone_number;

            $comment->save();

            $success = 'true';

            return $this->sendResponse($success, 'Customer feedback add successfully.');

        }else{

            return $this->sendError('Customer feedback can not be empty.');
        
        }

        
        
    }


    public function collectorRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'rate' => 'nullable',
            'user_id' => 'required',
            'body' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $client = Client::find($request->client_id);

        if (isset($request->rate)) {

            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rate;
            //$rating->user_id = auth()->user()->id;
            $rating->user_id = $request->user_id;
            $client->ratings()->save($rating);

            $success = 'true';

            return $this->sendResponse($success, 'Collector feedback add successfully.');

        }elseif(isset($request->body)) {

            $comment = new Comment();
            $comment->collector_userid = $client->user_id;
    
            $comment->client_id = $client->id;
            $comment->client_name = $client->name;
            $comment->client_firstname = $client->firstname;
            $comment->client_email = $client->email;
            $comment->client_address = $client->address;
            $comment->client_phone= $client->phone_number;
            $comment->status = 1;
            $comment->body = $request->body;
            $comment->user_id = $request->user_id;

            $user = User::findOrFail($comment->user_id);

            $comment->user_name = $user->name;
            $comment->user_firstname = $user->firstname;
            $comment->user_email = $user->email;
            $comment->user_address = $user->address;
            $comment->user_phone= $user->phone_number;
    
            $comment->save();

            $success = 'true';

            return $this->sendResponse($success, 'Collector feedback add successfully.');

        }elseif(isset($request->rate) && (isset($request->body))){

            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rate;
            //$rating->user_id = auth()->user()->id;
            $rating->user_id = $request->user_id;
            $client->ratings()->save($rating);

            $comment = new Comment();
            $comment->collector_userid = $client->user_id;
    
            $comment->client_id = $client->id;
            $comment->client_name = $client->name;
            $comment->client_firstname = $client->firstname;
            $comment->client_email = $client->email;
            $comment->client_address = $client->address;
            $comment->client_phone= $client->phone_number;
            $comment->status = 1;
            $comment->body = $request->body;
            $comment->user_id = $request->user_id;

            $user = User::findOrFail($comment->user_id);

            $comment->user_name = $user->name;
            $comment->user_firstname = $user->firstname;
            $comment->user_email = $user->email;
            $comment->user_address = $user->address;
            $comment->user_phone= $user->phone_number;
    
            $comment->save();

            $success = 'true';

            return $this->sendResponse($success, 'Collector feedback add successfully.');
        }else{

            return $this->sendError('Collector feedback can not be empty.');
        
        }

        
    }
}
