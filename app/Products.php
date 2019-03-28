<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['image_url', 'price', 'description', 'product_name'];
}
