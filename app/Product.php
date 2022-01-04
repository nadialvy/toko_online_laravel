<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    public $timestapms = false;
    
    protected $fillable = ['name', 'description', 'price', 'photo'];
}
