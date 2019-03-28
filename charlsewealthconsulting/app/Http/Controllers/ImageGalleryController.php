<?php

namespace App\Http\Controllers;

use App\ImageGallery;
use Illuminate\Http\Request;

use App\Event;
use Cloudder;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return csrf_token();
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
            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'caption' => 'string',
            'description' => 'string',
            'event' => 'required|int',
        ]);

        $event = Event::find($request->event);

        $image = $request->file('image')->getRealPath();

        Cloudder::upload($image, null);

        $image_url = Cloudder::show(Cloudder::getPublicId());

        $image_gallery = new ImageGallery();
        $image_gallery->fill($request->all());
        $image_gallery->image_url = $image_url;
        return $event->image_galleries()->save($image_gallery);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImageGallery  $imageGallery
     * @return \Illuminate\Http\Response
     */
    public function show(ImageGallery $imageGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImageGallery  $imageGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageGallery $imageGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImageGallery  $imageGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageGallery $imageGallery)
    {
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImageGallery  $imageGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ImageGallery $imageGallery)
    {
        return $imageGallery->destroy($id);
    }


}
