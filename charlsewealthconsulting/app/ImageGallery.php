<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ImageGallery extends Model
{
    protected $fillable = ['caption', 'description', 'image_url'];

    public function event (){
        return $this->belongsTo('App\Event');
    }

}
