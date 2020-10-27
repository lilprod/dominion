<?php

namespace App\Http\Controllers;
use App\KiloPrice;

use Illuminate\Http\Request;

class KiloPriceController extends Controller
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
        $kiloprices = KiloPrice::all(); //Get all kiloprices

        return view('kiloprices.index')->with('kiloprices', $kiloprices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kiloprices.create');
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
            'lavage_price' => 'required',
            'express_price' => 'required',
            'repassage_price' => 'required',
        ]);

        $kiloprice = new KiloPrice();
        $kiloprice->title = $request->input('title');
        $kiloprice->description = $request->input('description');
        $kiloprice->lavage_price = $request->input('lavage_price');
        $kiloprice->express_price = $request->input('express_price');
        $kiloprice->repassage_price = $request->input('repassage_price');

        $kiloprice->save();

        //Redirect to the kiloprices.index view and display message
        return redirect()->route('kiloprices.index')
            ->with('success',
             'Prix du kilo ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kiloprice = KiloPrice::findOrFail($id); //Find kiloprice of id = $id

        return view('kiloprices.show', compact('kiloprice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kiloprice = KiloPrice::findOrFail($id); //Find kiloprice of id = $id

        return view('kiloprices.edit', compact('kiloprice'));
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
        $kiloprice = KiloPrice::findOrFail($id); //Find kiloprice of id = $id

        $this->validate($request, [
            'title' => 'required|max:120',
            'description' => 'nullable',
            'lavage_price' => 'required',
            'express_price' => 'required',
            'repassage_price' => 'required',
        ]);

        $kiloprice->title = $request->input('title');
        $kiloprice->description = $request->input('description');
        $kiloprice->lavage_price = $request->input('lavage_price');
        $kiloprice->express_price = $request->input('express_price');
        $kiloprice->repassage_price = $request->input('repassage_price');

        $kiloprice->save();

        //Redirect to the articles.index view and display message
        return redirect()->route('kiloprices.index')
            ->with('success',
             'Prix du kilo édité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kiloprice = KiloPrice::findOrFail($id); //Find kiloprice of id = $id

        $kiloprice->delete();

        return redirect()->route('kiloprices.index')
            ->with('success',
             'Prix du kilo supprimé avec succès');
    }
}
