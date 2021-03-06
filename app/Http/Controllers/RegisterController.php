<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Client;
use App\Collector;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'firstname' => 'required',
            'email' => 'nullable|email',
            'phone_number' => 'required',
            'address' => 'nullable',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['role_id'] = 1;
        $input['profile_picture'] = 'avatar.jpg';
        $user = User::create($input);
        $user->assignRole('Customer');

        $customer = new Client();
        $customer->name = $request->input('name');
        $customer->firstname = $request->input('firstname');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');
        $customer->address = $request->input('address');
        $customer->profile_picture = 'avatar.jpg';
        $customer->user_id = $user->id;
        $customer->save();

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['firstname'] =  $user->firstname;
        $success['address'] =  $user->address;
        $success['phone_number'] =  $user->phone_number;
        $success['role_id'] =  $user->role_id;
   
        return $this->sendResponse($success, 'Utilisateur inscrit avec succès.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user1 = User::where('phone_number', $request->phone_number)->first();

        if(($user1 != '') && ($user1->role_id == $request->role_id)){

            if(Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                $success['id'] =  $user->id;
                $success['name'] =  $user->name;
                $success['firstname'] =  $user->firstname;
                $success['address'] =  $user->address;
                $success['phone_number'] =  $user->phone_number;
                $success['role_id'] =  $user->role_id;
                $success['profile_picture'] = asset('/storage/profile_images/'.$user->profile_picture);
    
                /* $user->firebase_token = $request->firebase_token;
                $user->save(); */
                return $this->sendResponse($success, 'Utilisateur connecté avec succès.');
            } 
            else{ 
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
        
    }

    /* public function checkemail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user == ''){
            return $this->sendResponse([], 'Email accepted.');
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Email already exist!','user'=> $user]);
        }

    } */

    public function checkemail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user == ''){
            return $this->sendResponse([], 'Email accepted.');
        }else{

            $response = [
                'success' => false,
                'data'    => $user,
                'message' =>'Email already exist!',
            ];
            return response()->json($response, 200);
        }

    } 

    public function checkphone(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if($user == ''){
            return $this->sendResponse([], 'Phone number accepted.');
        }else{
            $response = [
                'success' => false,
                'data'    => $user,
                'message' =>'Phone number already exist!',
            ];
            return response()->json($response, 200);
        }

    }

    public function checkcustomer(Request $request)
    {
        $user = User::where('role_id', $request->role_id)->first();

        if($user->role_id == 1){
            return $this->sendResponse([], 'Connexion accepted.');
        }else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }

    } 

    public function checkcollector(Request $request)
    {
        $user = User::where('role_id', $request->role_id)->first();

        if($user->role_id == 2){
            return $this->sendResponse([], 'Connexion accepted.');
        }else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }

    } 

    public function postToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'firebase_token' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::where('id', $request->user_id)->first();

        $user->firebase_token = $request->firebase_token;
        $user->save();
        $success = true;
        return $this->sendResponse($success, 'Utilisateur connecté avec succès.');
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

       /*  $response = 'Vous avez été déconnecter avec succès!';

        return response($response, 200); */
        $success = 'true';

        return $this->sendResponse($success, 'Utilisateur déconnecté avec succès.');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


    //change password api
    public function change_password(Request $request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return response()->json($arr);
    }

    //forgot_password
    public function forgot_password(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => "required|email",
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else {
            try {
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return response()->json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:
                        return response()->json(array("status" => 400, "message" => trans($response), "data" => array()));
                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            }
        }
        return response()->json($arr);
    }

    public function update_profile(Request $request)
    {
        // Get current user
        $userId = Auth::guard('api')->user()->id;
        $user = User::findOrFail($userId);

        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'firstname' => 'required|max:255',
            'email' => 'nullable',
            'address' => 'nullable',
            ///'phone_number' => 'nullable|number|unique:users',
            'profile_picture' => 'image|nullable',
        ]);

        if ($request->hasfile('profile_picture')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('profile_picture')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('profile_picture')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload Image
            $path = $request->file('profile_picture')->storeAs('public/profile_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'avatar.jpg';
        }

        // if fails redirects back with errors
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        // Fill user model
        $user->fill([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'address' => $request->address
        ]);

        if($user->role_id == 1){
            $client = Client::where('user_id', $user->id)
                            ->first();
            $client->name = $request->name;
            $client->firstname = $request->firstname;
            $client->email =  $request->email;
            $client->address = $request->address;
        
            $client->save();

        }elseif($user->role_id == 2){

            $collector = Collector::where('user_id', $user->id)
                                    ->first();
            $collector->name = $request->name;
            $collector->firstname = $request->firstname;
            $collector->email =  $request->email;
            $collector->address = $request->address;
           
            $collector->save();

        }

        $success = true;
        // Save user to database
        $user->save();
        // Redirect to route
        return $this->sendResponse($success, 'Profil édité avec succès.');
    }

    public function update_picture(Request $request)
    {
        $userId = Auth::guard('api')->user()->id;
        $user = User::findOrFail($userId);

        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'image|required',
        ]);

        if ($request->hasfile('profile_picture')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('profile_picture')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('profile_picture')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload Image
            $path = $request->file('profile_picture')->storeAs('public/profile_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'avatar.jpg';
        }

        // if fails redirects back with errors
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if($user->role_id == 1){

            $client = Client::where('user_id', $user->id)->first();

            $client->profile_picture = $fileNameToStore;
        
            $client->save();

        }elseif($user->role_id == 2){

            $collector = Collector::where('user_id', $user->id)->first();

            $collector->profile_picture = $fileNameToStore;
           
            $collector->save();

        }

        // Save user to database
        $user->profile_picture = $fileNameToStore;

        $user->save();

        $success = true;
        // Redirect to route
        return $this->sendResponse($success, 'Photo de profil éditée avec succès.');
    }
}
