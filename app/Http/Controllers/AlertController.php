<?php

namespace App\Http\Controllers;

use App\Alert;
use App\User;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all notifications and pass it to the view
        $user = auth()->user()->id;
        $alerts = Alert::where('receiver_id', $user)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('alerts.index')->with('alerts', $alerts);
    }


    public function lastNotifAjax(){
        $user = auth()->user()->id;
        $alerts = Alert::where('receiver_id', $user)
                                        ->orderBy('id', 'desc')
                                        ->limit(3)
                                        ->get();
        foreach($alerts as $alert){
            $sender = User::findOrFail($alert->sender_id);
            $alert->sender_name = $sender->name.' '.$sender->firstname;
            //$alert->profile_picture = url('/storage/profile_images/'.$alert->sender->profile_picture);
            $alert->profile_picture = $alert->sender->profile_picture;
            $alert->unread = Alert::where('status', 0)
                                    ->where('receiver_id', $user)
                                    ->count();
        }

            return $alerts;
    }

    public function updateStatusAjax(Request $request){
        $alert = Alert::find($request->get('id'));
        $alert->status = 1;
        $alert->save();
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
        //
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
