<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps = false;

    protected $fillable = ['cust_id', 'officer_id', 'date'];
}
