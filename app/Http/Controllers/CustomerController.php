<?php

namespace App\Http\Controllers;
use App\User;
use App\Client;
use App\Comment;

use Illuminate\Http\Request;

class CustomerController extends Controller
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
        //Get all customers and pass it to the view
        $customers = Client::all();

        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:120',
            'firstname' => 'required|max:120',
            /*'email' => 'required|email|unique:clients',*/
            /*'password' => 'required|min:6|confirmed',*/
            'email' => 'nullable',
            'phone_number' => 'required|unique:users',
            'address' => 'nullable',
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
            $fileNameToStore = $_ENV['APP_URL'].'/storage/profile_images/avatar.jpg';
        }

        $client = new Client();
        $client->name = $request->input('name');
        $client->firstname = $request->input('firstname');
        $client->email = $request->input('email');
        $client->phone_number = $request->input('phone_number');
        $client->address = $request->input('address');
        $client->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        $client->user_id = auth()->user()->id;

        $user = new User();
        $user->name = $request->input('name');
        $user->firstname = $request->input('firstname');
        $user->email = $request->input('email');
        $user->password = 123456;
        $user->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->role_id = 1;
        $user->is_activated = 1;

        $user->save();
        $user->assignRole('Client');

        $client->save();
        //Redirect to the customers.index view and display message
        /* return redirect()->route('customers.index')
            ->with('success',
             'Client ajouté avec succès.'); */

        $customer = Client::findOrFail($client->id);
        $customer->user_id = $user->id; 
        $customer->save();

        return redirect()->route('depositedarticle.create', $client->id)
        ->with('success',
        'Client ajouté avec succès. Vous pouvez procéder à son dépôt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Client::findOrFail($id);

        $comments = Comment::where('client_id', $customer->id)->get();
        foreach($comments as $comment){
            $user = User::findOrFail($comment->user_id);
            $comment->user_profilImage = $user->profile_picture;
        }

        return view('customers.show', compact('customer', 'comments'));

        //return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Client::findOrFail($id); //Find client of id = $id

        return view('customers.edit', compact('customer'));
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

        $client = Client::findOrFail($id);

        $user = User::findOrFail($client->user_id);
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:120',
            'firstname' => 'required|max:120',
            /*'email' => 'required|email|unique:clients,email,'.$id,*/
            /*'password' => 'required|min:6|confirmed',*/
            'email' => 'nullable',
            'phone_number' => 'required|unique:users,phone_number,'.$client->user_id,
            'address' => 'nullable',
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
            $fileNameToStore = $_ENV['APP_URL'].'/storage/profile_images/avatar.jpg';
        }

        $client->name = $request->input('name');
        $client->firstname = $request->input('firstname');
        $client->email = $request->input('email');
        $client->phone_number = $request->input('phone_number');
        $client->address = $request->input('address');

        if ($request->hasfile('profile_picture')) {
            $client->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        }

        $user->name = $request->input('name');
        $user->firstname = $request->input('firstname');
        $user->email = $request->input('email');
        $user->password = 123456;
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        if ($request->hasfile('profile_picture')) {
            $user->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        }

        $user->save();
        $client->save();
        //Redirect to the customers.index view and display message
        return redirect()->route('customers.index')
            ->with('success',
             'Client édité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Client::findOrFail($id);
        $user = User::findOrFail($customer->user_id);

        if ($customer->profile_picture != 'avatar.jpg') {
            Storage::delete('public/profile_images/'.$customer->profile_picture);
        }

        if ($user->profile_picture != 'avatar.jpg') {
            Storage::delete('public/profile_images/'.$user->profile_picture);
        }

        $user->delete();
        $customer->delete();


        return redirect()->route('customers.index')
            ->with('success',
             'Client supprimé avec succès');
    }
}
