<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Collector;
use App\Comment;
use App\Order;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

use Illuminate\Http\Request;

class CollectorController extends Controller
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
        $collectors = Collector::all(); //Get all collectors

        return view('collectors.index')->with('collectors', $collectors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('customers.create');
        //$roles = Role::whereNotIn('id', array(3))->get();
     
        return view('collectors.create');
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
            /*'email' => 'required|email|unique:users',*/
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

        $collector = new Collector();
        $collector->name = $request->input('name');
        $collector->firstname = $request->input('firstname');
        $collector->email = $request->input('email');
        $collector->phone_number = '224'.$request->input('phone_number');
        $collector->address = $request->input('address');
        $collector->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        $collector->user_id = auth()->user()->id;

        $user = new User();
        $user->name = $request->input('name');
        $user->firstname = $request->input('firstname');
        $user->email = $request->input('email');
        //$user->password = $request->input('password');
        $user->password = 123456;
        $user->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        $user->phone_number = '224'.$request->input('phone_number');
        $user->address = $request->input('address');
        $user->role_id = 2;
        $user->is_activated = 1;

        $user->save();
        $user->assignRole('Collector');

        $collector->save();
        

        $collector = Collector::findOrFail($collector->id);
        $collector->user_id = $user->id; 
        $collector->save();

        /*return redirect()->route('depositedarticle.create', $client->id)
        ->with('success',
        'Client ajouté avec succès. Vous pouvez procéder à son dépôt');*/

        //Redirect to the collectors.index view and display message
        return redirect()->route('collectors.index')
            ->with('success',
             'Collecteur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collector = Collector::findOrFail($id); //Find collector of id = $id

        $comments = Comment::where('collector_id', $collector->id)->get();
        foreach($comments as $comment){
            $user = User::findOrFail($comment->user_id);
            $comment->user_profilImage = $user->profile_picture;
        }

        return view('collectors.show', compact('collector', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collector = Collector::findOrFail($id); //Find collector of id = $id

        return view('collectors.edit', compact('collector'));

        //$roles = Role::whereNotIn('id', array(3))->get();

        //return view('collectors.edit', compact('collector','roles'));
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
        //Validate name, email and password fields
        $collector = Collector::findOrFail($id);

        $user = User::findOrFail($collector->user_id);

        $this->validate($request, [
            'name' => 'required|max:120',
            'firstname' => 'required|max:120',
            /*'email' => 'required|email',*/
            /*'password' => 'required|min:6|confirmed',*/
            'email' => 'nullable',
            'phone_number' => 'required|unique:users,phone_number,'.$collector->user_id,
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

        

        $collector->name = $request->input('name');
        $collector->firstname = $request->input('firstname');
        $collector->email = $request->input('email');
        $collector->phone_number = '224'.$request->input('phone_number');
        $collector->address = $request->input('address');

        if ($request->hasfile('profile_picture')) {
            $collector->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        }

        $user->name = $request->input('name');
        $user->firstname = $request->input('firstname');
        $user->email = $request->input('email');
        //$user->password = $request->input('password');
        $user->password = 123456;
        $user->role_id = 2;
        $user->phone_number = '224'.$request->input('phone_number');
        $user->address = $request->input('address');
        if ($request->hasfile('profile_picture')) {
            $user->profile_picture = $_ENV['APP_URL'].'/storage/profile_images/'.$fileNameToStore;
        }

        $user->save();
        $collector->save();
        //Redirect to the customers.index view and display message
        return redirect()->route('collectors.index')
            ->with('success',
             'Collecteur édité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collector = Collector::findOrFail($id);
        $user = User::findOrFail($collector->user_id);

        if ($collector->profile_picture != 'avatar.jpg') {
            Storage::delete('public/profile_images/'.$collector->profile_picture);
        }

        if ($user->profile_picture != 'avatar.jpg') {
            Storage::delete('public/profile_images/'.$user->profile_picture);
        }

        $user->delete();
        $collector->delete();


        return redirect()->route('collectors.index')
            ->with('success',
             'Collecteur supprimé avec succès');
    }
}
