<?php

namespace App\Http\Controllers;

use App\Accommodation;
use Illuminate\Http\Request;
use App\LogEngine;
use Auth;

use Session;

class AccommodationController extends Controller
{

    public function __construct()
     {
         $this->middleware('auth',['only' => 'create','store','edit','update','destroy']);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accommodations = Accommodation::orderBy('areaName')->get();
        return view('accommodation.index')->withAccommodations($accommodations);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accommodation.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
       $this->validate($request, array(
               'gender'          => 'required|numeric',
               'areaName'        => 'required|max:255',
               'locationofAcc'   => 'required|max:255',
               'category'        => 'required|max:255',
               'coord'           => 'required|max:255',
               'contact'         => 'required|numeric',
               'isFull'          => 'required|numeric',
           ));
       // store in the database
       $accommodations = new Accommodation;
       $log = new LogEngine();
       $accommodations->gender = $request->gender;
       $accommodations->areaName = $request->areaName;
       $accommodations->locationofAcc = $request->locationofAcc;
       $accommodations->category = $request->category;
       $accommodations->isFull = $request->isFull;
       $accommodations->coord = $request->coord;
       $accommodations->contact = $request->contact;
       $log->user_id=Auth::user()->id;
       $log->name=Auth::user()->name;
       $log->action="Accommodation";
       $log->actionval = 1;
       $log->detailed_data = $accommodations;
       $log->save();
       $accommodations->save();
       Session::flash('success', 'Accommodation Details successfully added!');
       return redirect()->route('accommodation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function show(Accommodation $accommodation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function edit(Accommodation $accommodation)
    {
        $acc = Accommodation::find($accommodation->id);
        return view('accommodation.edit')->withAcc($acc);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        $acc = Accommodation::find($accommodation->id);
        $this->validate($request, array(
            'gender'          => 'required|numeric',
            'areaName'        => 'required|max:255',
            'locationofAcc'   => 'required|max:255',
            'category'          => 'required|max:255',
            'coord'          => 'required|max:255',
            'contact'          => 'required|numeric',
            'isFull'          => 'required|numeric',
            ));
        $input = $request->all();
        $log = new LogEngine();
        $log->user_id=Auth::user()->id;
        $log->name=Auth::user()->name;
        $log->action="Accommodation";
        $log->actionval = 2;
        $log->detailed_data = $acc;
        $log->save();
        $acc->fill($input)->save();
        Session::flash('success', 'Accommodation details successfully edited!');
        return redirect()->route('accommodation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accommodation $accommodation)
    {
        $acc = Accommodation::find($accommodation->id);
        $log = new LogEngine();
        $log->user_id=Auth::user()->id;
        $log->name=Auth::user()->name;
        $log->action="Accommodation";
        $log->actionval = 3;
        $log->detailed_data = $acc;
        $log->save();
        $acc->delete();
        Session::flash('success', 'Accommodation details successfully removed!');
        return redirect()->route('accommodation.index');
    }
}
