<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profils.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:120',
            'firstname' => 'required|max:120',
            'email' => 'required|email',
            'address' => 'nullable',
            'phone_number' => 'required',
        ]);

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        
        $name = $request->input('name');
        $firstname = $request->input('firstname');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone_number = $request->input('phone_number');

        User::where('id', $user_id)
                    ->update([
                            'name' => $name,
                            'firstname' => $firstname,
                            'email' => $email,
                            'address' => $address,
                            'phone_number' => $phone_number,
                        ]);
       
        return redirect('profils')->with('success', 'Votre profil a été mis à jour avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    public function setting()
    {
        return view('profils.setting');
    }

    public function updatePassword(Request $request)
    {
        //Validate password fields
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $userid = auth()->user()->id;
        //$user = User::findOrFail($user_id); //Get user specified by id


        try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {

                    return redirect()->back()->with('error', 'Votre ancien mot de passe est erroné');
                    //$arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    return redirect()->back()->with('error', 'Votre nouveau mot de passe est similaire à l\'ancienne');
                    //$arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($request->new_password)]);

                    return redirect('profils')->with('success', 'Votre mot de passe a été changé');
                    //$arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }

                return redirect('profils')->with('error', $msg);
                //$arr = array("status" => 400, "message" => $msg, "data" => array());
            }


        //$user->password = $request->input('password');
        //$user->save();

        //return redirect('profils')->with('success', 'Votre mot de passe a été changé');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
