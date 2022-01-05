<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //read data start
    public function show()
    {
        $data = DB::table('order')
        ->join('customers', 'order.cust_id', '=', 'customers.cust_id')
        ->join('officer', 'order.officer_id', '=', 'officer.officer_id')
        ->select('order.transaction_id', 'customers.cust_id', 'officer.officer_id', 'order.date')
        ->get();

        return Response() -> json($data);
    }

    public function detail($id){
        if(Order::where('transaction_id', $id)->exists()){
            $data_order = DB::table('order')
            ->join('customers', 'order.cust_id', '=' , 'customers.cust_id')
            ->join('officer', 'order.officer_id', '=' , 'officer.officer_id')
            ->select('order.transaction_id', 'order.date', 'customers.cust_id', 'officer.officer_id')
            ->where('order.transaction_id', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Could not find data']);
        }
    }
    //read data end

    //create data start
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'cust_id' => 'required',
                'officer_id' => 'required',
            ]
        );

        if($validator->fails()){
            return Response() -> json($validator -> errors());
        }

        $simpan = DB::table('order')
        ->insert([
            'cust_id' => $request->cust_id,
            'officer_id' => $request->officer_id,
            'date' => date("Y-m-d")
        ]);

        if($simpan){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success adding new data!'
            ]);
        }else {
            return Response() -> json(['status' => 0]);
        }
    }
    //create data end
}
