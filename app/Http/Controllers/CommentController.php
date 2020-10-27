<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Client;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('status', 1)
                        ->get(); //Get all comments

        return view('comments.index')->with('comments', $comments);
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
        $this->validate($request, [
            'user_id' => 'required',
            'client_userid' => 'required',
            'body' => 'required',
        ]);


        $comment = new Comment();
        $comment->client_userid = $request->client_userid;
        $client = Client::where('user_id', $comment->client_userid)
                          ->first();

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

        return redirect()->route('customers.show', $comment->client_id)
        ->with('success',
         'Commentaire ajouté à avec succès.');
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
        $comment = Comment::findOrFail($id);

        $this->validate($request, [
            'user_id' => 'required',
            'client_userid' => 'required',
            'body' => 'required',
        ]);

        $comment = new Comment();
        $comment->client_userid = $request->client_userid;
        $client = Client::where('user_id', $comment->client_userid)
                          ->first();

        $comment->client_id = $client->id;
        $comment->client_name = $client->name;
        $comment->client_firstname = $client->firstname;
        $comment->client_email = $client->email;
        $comment->client_address = $client->address;
        $comment->client_phone= $client->phone_number;
        $comment->status = 1;
        $comment->body = $request->body;
        $comment->user_id = $request->user_id;
        $user = User::finOrFail($comment->user_id);
        $comment->user_name = $user->name;
        $comment->user_firstname = $user->firstname;
        $comment->user_email = $user->email;
        $comment->user_address = $user->address;
        $comment->user_phone= $user->phone_number;

        $comment->save();

        return redirect()->route('customers.show', $comment->client_userid)
        ->with('success',
         'Commentaire modifié à avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('customers.show', $comment->client_userid)
        ->with('success', 'Commentaire supprimé à avec succès.');
    }
}
