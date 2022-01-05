<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    //read data start
    public function show(){
        $data = DB::table('order_detail')
        ->join('order', 'order_detail.transaction_id', '=', 'order.transaction_id')
        ->join('product', 'order_detail.product_id', '=', 'product.product_id')
        ->select('order_detail.detail_transaction_id', 'order.transaction_id', 'product.product_id', 'order_detail.qty', 'order_detail.subtotal')
        ->get();

        return Response() -> json($data);
    }

    public function detail($id){
        if(OrderDetail::where('detail_transaction_id', $id)->exists()){
            $data_order = DB::table('order_detail')
            ->join('order', 'order_detail.transaction_id', '=' , 'order.transaction_id')
            ->join('product', 'order_detail.product_id', '=' , 'product.product_id')
            ->select('order.transaction_id', 'order.date', 'order.cust_id', 'product.product_id', 'product.name', 'order_detail.qty', 'order_detail.subtotal')
            ->where('order_detail.detail_transaction_id', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }
    //read data end
    
    //create data start
    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'transaction_id' => 'required',
                'product_id' => 'required',
                'qty' => 'required'
            ]
        );

        if($validator -> fails()){
            return Response() -> json($validator->errors());
        }

        //count subtotal
        $product_id = $request->product_id;
        $qty = $request->qty;
        $price = DB::table('product')
        ->where('product_id', $product_id)
        ->value('price');
        $subtotal = $price * $qty;

        $simpan = DB::table('order_detail')
        ->insert([
            'transaction_id' => $request->transaction_id,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'subtotal' => $subtotal
        ]);

        if($simpan){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success adding new data!'
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
            'transaction_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        //count subtotal
        $product_id = $request->product_id;
        $qty = $request->qty;
        $price = DB::table('product')
        ->where('product_id', '=', $product_id)
        ->value('price');
        $subtotal = $price * $qty;

        $update = DB::table('order_detail')
        -> where('detail_transaction_id', '=', $id)
        ->update(
            [
                'transaction_id' => $request->transaction_id,
                'product_id' => $request->product_id,
                'qty' =>  $request->qty,
                'subtotal' => $subtotal
            ]
        );

        $data = OrderDetail::where('detail_transaction_id', '=', $id)->get();
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
