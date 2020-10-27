<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CodePromo;

class CodePromoController extends Controller
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
        $codepromos = CodePromo::all(); //Get all codepromos

        return view('codepromos.index')->with('codepromos', $codepromos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codepromos.create');
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
            'begin_date' => 'required',
            'end_date' => 'required',
            'pourcentage' => 'required',
            'quota' => 'nullable',
        ]);

        $codepromo = new CodePromo();
        $codepromo->title = $request->input('title');
        $codepromo->begin_date = $request->input('begin_date');
        $codepromo->end_date = $request->input('end_date');
        $codepromo->pourcentage = $request->input('pourcentage');
        $codepromo->quota = $request->input('quota');
        $codepromo->leftover = $request->input('quota');
        $codepromo->status = 0;

        $codepromo->save();

        //Redirect to the codepromos.index view and display message
        return redirect()->route('codepromos.index')
            ->with('success',
             'Nouveau Code promo ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $codepromo = CodePromo::findOrFail($id); //Find codepromo of id = $id

        return view('codepromos.show', compact('codepromo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $codepromo = CodePromo::findOrFail($id); //Find codepromo of id = $id

        return view('codepromos.edit', compact('codepromo'));
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
        $codepromo = CodePromo::findOrFail($id); //Find codepromo of id = $id

        $this->validate($request, [
            'title' => 'required|max:120',
            'begin_date' => 'required',
            'end_date' => 'required',
            'pourcentage' => 'required',
            'quota' => 'nullable',
        ]);

        $codepromo = new CodePromo();
        $codepromo->title = $request->input('title');
        $codepromo->begin_date = $request->input('begin_date');
        $codepromo->end_date = $request->input('end_date');
        $codepromo->pourcentage = $request->input('pourcentage');
        $codepromo->quota = $request->input('quota');
        $codepromo->leftover = $request->input('quota');
        $codepromo->status = 0;

        $codepromo->save();

        //Redirect to the codepromos.index view and display message
        return redirect()->route('codepromos.index')
            ->with('success',
             'Code promo édité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $codepromo = CodePromo::findOrFail($id); //Find codepromo of id = $id

        $codepromo->delete();

        return redirect()->route('codepromos.index')
            ->with('success',
             'Code promo supprimé avec succès');
    }
}
