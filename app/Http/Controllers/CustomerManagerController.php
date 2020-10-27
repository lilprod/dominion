<?php

namespace App\Http\Controllers;

use App\Client;
use App\Delivery;
use App\Deposit;
use Illuminate\Http\Request;

class CustomerManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','customer']); //customer middleware lets only users with a //specific permission permission to access these resources
    }

    public function mydeposits()
    {
        $user_id = auth()->user()->id;
        $client = Client::where('user_id', $user_id)
                                ->first();
        $deposits = Deposit::where('client_id', $client->id)
                            ->get();

        return view('clients.mydeposits', compact('deposits'));
    }

    public function mydeliveries()
    {
        $user_id = auth()->user()->id;
        $client = Client::where('user_id', $user_id)
                            ->first();
        $deliveries = Delivery::where('client_id', $client->id)
                            ->get();

        return view('clients.mydeliveries', compact('deliveries'));
    }
}
