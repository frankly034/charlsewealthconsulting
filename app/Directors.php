<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directors extends Model
{
    protected $fillable = [
        'name','specialisation','description',
    ];
}
