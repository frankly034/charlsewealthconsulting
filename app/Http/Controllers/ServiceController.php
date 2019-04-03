<?php

namespace App\Http\Controllers;

use App\Service;
use Cloudder;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->get();

        return $services;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return view('pages.create_services'); 
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
            'service_name' => 'required|string',
            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string'
        ]);
        $image = $request->file('image')->getRealPath();

        Cloudder::upload($image, null);

        $image_url = Cloudder::show(Cloudder::getPublicId());


        $service = new Service;
        $service->service_name = $request->service_name;
        $service->description = $request->description;
        $service->image_url = $image_url;
        $service->save();
        return $service;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service, $id)
    {
        $service = Service::findOrFail($id);
        return $service;   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service, $id)
    {
        $service = Service::findOrFail($id);
        return $service;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'service_name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000'
        ]);
        if($request->hasFile('image')){
        $image = $request->file('image')->getRealPath();

        Cloudder::upload($image, null);

        $image_url = Cloudder::show(Cloudder::getPublicId());
        }
        
        $service = Service::findOrFail($id);
        $service->description = $request->description;
        if($request->hasFile('image')){
            $url_id = $service->image_url;
            $url_arr = explode("/",$url_id);
            $url_last = count($url_arr)-1;
            $url_last_id = explode(".", $url_arr[$url_last]);
            $publicId = $url_last_id[0];
            Cloudder::destroyImage($publicId);
            $service->image_url = $image_url;
        }
        $service->service_name = $request->service_name;
        $service->update();
        return $service;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $url_id = $service->image_url;
        $url_arr = explode("/",$url_id);
        $url_last = count($url_arr)-1;
        $url_last_id = explode(".", $url_arr[$url_last]);
        $publicId = $url_last_id[0];
        Cloudder::destroyImage($publicId);
        $service->delete();
        return $service;
    }
}
