<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers'; //$table menyimpan informasi nama tabel customers
    public $timestamps = false;

    protected $fillable = ['name', 'address', 'no', 'usn', 'pass'];
}
