<?php

namespace App\Http\Controllers;

use App\Directors;
use Cloudder;
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
        $this->validate($request,[
            'name' => 'required|string',
            'description' => 'required',
            'specialisation' =>'nullable',
            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'intagram' => 'nullable'
        ]);

        $image = $request->file('image')->getRealPath();

        Cloudder::upload($image, null);

        $image_url = Cloudder::show(Cloudder::getPublicId());


        $director = new Directors();
        $director->name = $request->name;
        $director->description = $request->description;
        $director->specialisation = $request->specialisation;
        $director->image_url = $image_url;
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
        dd($request->all());
        
        $this->validate($request,[
            'name' => 'required|string',
            'description' => 'nullable',
            'specialisation' =>'nullable',
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable'
        ]);
        
        if($request->hasFile('image')){
            $image = $request->file('image')->getRealPath();

            Cloudder::upload($image, null);

            $image_url = Cloudder::show(Cloudder::getPublicId());
        }   
        

        $director = Directors::findOrFail($id);
        
        $director->name = $request->name;
        $director->description = $request->description;
        $director->specialisation = $request->specialisation;
        if($request->hasFile('image')){
            $url_id = $director->image_url;
            $url_arr = explode("/",$url_id);
            $url_last = count($url_arr)-1;
            $url_last_id = explode(".", $url_arr[$url_last]);
            $publicId = $url_last_id[0];
            Cloudder::destroyImage($publicId);
            $director->image_url = $image_url;
        }
        
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
            $url_id = $director->image_url;
            $url_arr = explode("/",$url_id);
            $url_last = count($url_arr)-1;
            $url_last_id = explode(".", $url_arr[$url_last]);
            $publicId = $url_last_id[0];
            Cloudder::destroyImage($publicId);
        $director->delete();
        return $director;


    }
}
