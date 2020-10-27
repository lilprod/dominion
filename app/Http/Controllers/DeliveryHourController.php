<?php

namespace App\Http\Controllers;
use App\DeliveryHour;

use Illuminate\Http\Request;

class DeliveryHourController extends Controller
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
        $deliveryhours = DeliveryHour::all(); //Get all deliveryhours

        return view('deliveryhours.index')->with('deliveryhours', $deliveryhours);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deliveryhours.create');
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
            'lavage_hour' => 'required',
            'express_hour' => 'required',
            'repassage_hour' => 'required',
        ]);

        $deliveryhour = new DeliveryHour();
        $deliveryhour->lavage_hour = $request->input('lavage_hour');
        $deliveryhour->express_hour = $request->input('express_hour');
        $deliveryhour->repassage_hour = $request->input('repassage_hour');

        $deliveryhour->save();

        //Redirect to the articles.index view and display message
        return redirect()->route('deliveryhours.index')
            ->with('success',
             'Nombre d\'Heure de retrait ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliveryhour = DeliveryHour::findOrFail($id); //Find deliveryhour of id = $id

        return view('deliveryhours.show', compact('deliveryhour'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliveryhour = DeliveryHour::findOrFail($id); //Find deliveryhour of id = $id

        return view('deliveryhours.edit', compact('deliveryhour'));
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
        $deliveryhour = DeliveryHour::findOrFail($id); //Find deliveryhour of id = $id

        $this->validate($request, [
            'lavage_hour' => 'required',
            'express_hour' => 'required',
            'repassage_hour' => 'required',
        ]);

        $deliveryhour->lavage_hour = $request->input('lavage_hour');
        $deliveryhour->express_hour = $request->input('express_hour');
        $deliveryhour->repassage_hour = $request->input('repassage_hour');

        $deliveryhour->save();

        //Redirect to the articles.index view and display message
        return redirect()->route('deliveryhours.index')
            ->with('success',
             'Nombre d\'Heure de retrait édité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliveryhour = DeliveryHour::findOrFail($id); //Find deliveryhour of id = $id

        $deliveryhour->delete();

        return redirect()->route('deliveryhours.index')
            ->with('success',
             'Nombre d\'Heure de retrait supprimé avec succès');
    }
}
