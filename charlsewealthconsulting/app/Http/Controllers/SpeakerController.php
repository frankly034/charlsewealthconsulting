<?php

namespace App\Http\Controllers;

use App\Speaker;
use Illuminate\Http\Request;

use App\Event;
use Cloudder;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'photo' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'name' => 'string',
            'phone' => 'string|min:11',
            'profile' => 'string',
            'email' => 'email',
            'facebook' => 'url',
            'twitter' => 'url',
            'instagram' => 'url',
            'event' => 'required|int',
        ]);

        $event = Event::find($request->event);

        $photo = $request->file('photo')->getRealPath();

        Cloudder::upload($photo, null);

        $photo_url = Cloudder::show(Cloudder::getPublicId());

        $speaker = new Speaker();
        $speaker->fill($request->all());
        $speaker->photo_url = $photo_url;
        return $event->speakers()->save($speaker);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speaker $speaker)
    {
        $this->validate($request, [
            'photo' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'name' => 'string',
            'phone' => 'string|min:11',
            'profile' => 'string',
            'email' => 'email',
            'facebook' => 'url',
            'twitter' => 'url',
            'instagram' => 'url',
        ]);
        if ($request->file('photo')){
            $photo = $request->file('photo')->getRealPath();
            Cloudder::upload($photo, null);
            $photo_url = Cloudder::show(Cloudder::getPublicId());
            $speaker->photo_url = $photo_url;
        }
        $speaker->fill($request->all());  
        return $speaker->save() ? $speaker : 'something went wrong';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        return $speaker->delete();
    }
}
