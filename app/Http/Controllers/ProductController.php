<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //read data start
    public function show()
    {
        return Product::all();
    } 

    public function detail($id)
    {   
        if(Product::where('product_id', $id)->exists()){
            $detail_product = DB::table('product')
            ->where('product.product_id', '=', $id)
            ->get();

            return Response()->json($detail_product);
        } else {
            return Response() ->json(['message' => 'Could not find data']);
        }
    }
    //read data end

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
