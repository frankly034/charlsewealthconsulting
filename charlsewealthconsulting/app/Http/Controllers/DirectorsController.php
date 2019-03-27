<?php

namespace App\Http\Controllers;

use App\Directors;
use Illuminate\Http\Request;

class DirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directors = Directors::latest()->get();
        return $directors;
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
        $this->validate([
            'name' => 'required|string',
            'description' => 'required',
            'specialisation' =>'nullable',
            'image_url' => 'nullable',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'intagram' => 'nullable'
        ]);

        $director = new Directors();
        $director->name = $request->name;
        $director->description = $request->description;
        $director->specialisation = $request->specialisation;
        $director->image_url = " ";
        $director->twitter = $request->twitter;
        $director->facebook = $request->facebook;
        $director->instagram = $request->instagram;
        $director->save();
        return $director;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Directors  $directors
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $director = Directors::findOrFail($id);
        
        return $director;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Directors  $directors
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $director = Directors::findOrFail($id);
        return $director;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Directors  $directors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required',
            'specialisation' =>'nullable',
            'image_url' => 'nullable',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'intagram' => 'nullable'
        ]);

        $director = Directors::findOrFail($id);
        $director->name = $request->name;
        $director->description = $request->description;
        $director->specialisation = $request->specialisation;
        $director->image_url = " ";
        $director->twitter = $request->twitter;
        $director->facebook = $request->facebook;
        $director->instagram = $request->instagram;
       
        $director->update();
        return $director;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Directors  $directors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $director = Directors::findOrFail($id);
        $director->delete();
        return $director;


    }
}
