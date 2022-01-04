<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = 'officer';
    public $timestaps = false;

    protected $fillable = ['name', 'usn', 'pass', 'level'];
}
