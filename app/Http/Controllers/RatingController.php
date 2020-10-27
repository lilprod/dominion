<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        request()->validate([
            'client_id' => 'required',
            'rate' => 'required'
        ]);

        $client = Client::find($request->client_id);
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $request->rate;
        $rating->user_id = auth()->user()->id;
        $client->ratings()->save($rating);
        //return redirect()->route("posts");

        return redirect()->route('customers.show', $client->id)
        ->with('success',
         'Note ajouté à avec succès.');
    }
}
