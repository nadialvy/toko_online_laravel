<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //create data start
    public function store (Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'photo' => 'required'
            ]
        );

        if($validator -> fails()){
            return Response() -> json($validator->errors());
        }

        $simpan = DB::table('product')
        ->insert([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $request->photo
        ]);

        if($simpan){
            return Response() -> json(['status' => 1]);
        } else {
            return Response() -> json(['status' => 0]);
        }
    }

    //create data end
}
