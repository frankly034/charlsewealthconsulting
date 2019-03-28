<?php

namespace App\Http\Controllers;

use App\Service;
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
        $this->validate([
            'service_name' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string'
        ]);
        $service = new Service;
        $service->service_name = $request->service_name;
        $service->description = $request->description;
        $service->image_url = $request->image_url;
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
        $this->validate([
            'service_name' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string'
        ]);
        
        $service = Service::findOrFail($id);
        $service->description = $request->description;
        $service->image_url = $request->image_url;
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
        $service = Service::fiindOrFail($id);
        $service->delete();
        return $service;
    }
}
