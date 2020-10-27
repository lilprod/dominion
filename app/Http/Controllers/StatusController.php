<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etats = Status::all(); //Get all etats

        return view('status.index')->with('etats', $etats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.create');
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
            'title' => 'required|max:120',
            'description' => 'nullable',
        ]);

        $etat = new Status();
        $etat->title = $request->input('title');
        $etat->description = $request->input('description');

        $etat->save();

        //Redirect to the status.index view and display message
        return redirect()->route('status.index')
            ->with('success',
             'Nouvel état d\'article ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etat = Status::findOrFail($id); //Find etat of id = $id

        return view('status.show', compact('etat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $etat = Status::findOrFail($id); //Find etat of id = $id

        return view('status.edit', compact('etat'));
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
        $this->validate($request, [
            'title' => 'required|max:120',
            'description' => 'nullable',
        ]);

        $etat = Status::findOrFail($id);

        $etat->title = $request->input('title');
        $etat->description = $request->input('description');

        $etat->save();

        //Redirect to the status.index view and display message
        return redirect()->route('status.index')
            ->with('success',
             'Etat d\'article edité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etat = Status::findOrFail($id);

        $etat->delete();

        return redirect()->route('status.index')
            ->with('success',
             'Etat d\'article supprimé avec succès');
    }
}
