<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Comment;
use App\Client;
use App\Collector;
use App\User;
use App\Http\Resources\Comment as CommentResource;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$comments = auth()->user()->mycomments();
        $comments = Comment::all();

        return $this->sendResponse(CommentResource::collection($comments), 'Comments retrieved successfully.');
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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'client_userid' => 'required',
            'body' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

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

        return $this->sendResponse(new CommentResource($comment), 'Comment created successfully.');
    }

    public function clientcomment(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'collector_userid' => 'required',
            'body' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $comment = new Comment();
        $comment->collector_userid = $request->client_userid;
        $collector = Collectort::where('user_id', $comment->collector_userid)
                            ->first();

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

        return $this->sendResponse(new CommentResource($comment), 'Comment created successfully.');
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
    public function update(Request $request, Comment $comment)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'client_userid' => 'required',
            'body' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if($comment->user_id == Auth()->user()->id){
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

        }else{
            return $this->sendError('This Comment can not be updated.');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        if($comment->user_id == Auth()->user()->id){

            $comment->delete();
            return $this->sendResponse([], 'Comment deleted successfully.');

        }else{
            return $this->sendError('This Comment can not be deleted.');
        }
        
    }
}
