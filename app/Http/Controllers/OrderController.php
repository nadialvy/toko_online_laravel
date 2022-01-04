<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
            return Response() -> json(['status' => 1]);
        }else {
            return Response() -> json(['status' => 0]);
        }
    }
    //create data end
}
