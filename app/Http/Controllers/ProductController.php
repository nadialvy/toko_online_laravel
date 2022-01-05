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

        $data = Product::where('name', '=', $request->name)->get();
        if($simpan){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success adding new data!',
                'data' => $data   
            ]);
        } else {
            return Response() -> json(['status' => 0]);
        }
    }
    //create data end

    //update data start
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'description'  => 'required',
            'price'  => 'required',
            'photo'  => 'required'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }
        
        $update = DB::table('product')
        ->where('product_id', '=', $id)
        ->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'photo' => $request->photo
            ]
        );

        $data = Product::where('product_id', '=', $id)->get();
        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success updating data!',
                'data' => $data  
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed updating data!'
            ]);
        }
    }
    //update data end
}
