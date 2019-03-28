<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $fillable = ['name', 'photo_url', 'profile', 'email', 'phone', 'facebook', 'twitter', 'instagram','event_id'];

    public function event(){
        return $this->belongsTo('App\Event');
    }

}
