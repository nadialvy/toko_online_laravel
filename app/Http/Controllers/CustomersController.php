<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    //read data start
    public function show()
    {
        return Customers::all();
    }

    public function detail($id){
        if(Customers::where('cust_id', $id)->exists()){
            $detail_cust = DB::table('customers')
            ->select('customers.cust_id', 'customers.name', 'customers.address', 'customers.no', 'customers.usn', 'customers.pass')
            ->where('cust_id', '=', $id)
            ->get();
            return Response()->json($detail_cust);
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
                'name' => 'required',
                'address' => 'required',
                'no' => 'required',
                'usn' => 'required',
                'pass' => 'required'
            ]
        );

        if($validator -> fails()) {
            return Response() -> json($validator->errors());
        }

        $simpan = DB::table('customers')
        ->insert([
            'name' => $request->name,
            'address' => $request->address,
            'no' => $request->no,
            'usn' => $request->usn,
            'pass' => $request->pass
        ]);

        $data = Customers::where('name', '=', $request->name) -> get();
        if($simpan){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success adding new data!',
                'data' => $data   
            ]);
        }else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed adding new data!'
            ]);
        }
    }
    //create data end

    //update data start
        public function update($id, Request $request){
            $validator=Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'no' => 'required',
                'usn' => 'required',
                'pass' => 'required'
            ]);
    
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
    
            $ubah = DB::table('customers')
            ->where('cust_id', '=', $id)
            ->update(
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'no' => $request->no,
                    'usn' => $request->usn,
                    'pass' => $request->pass
                ]
            );
            
            $data = Customers::where('cust_id', '=', $id)->get();
            if($ubah){
                return Response() ->json([
                    'status' => 1,
                    'message' => 'Success updating data!',
                    'data' => $data  
                ]);
            } else {
                return Response() -> jsnon([
                    'status' => 0,
                    'message' => 'Failed updating data!'
                ]);
            }
        }
    //update data end
    
    //delete data start
    public function delete($id){
        $delete = DB::table('customers')
        -> where('cust_id', '=', $id)
        -> delete();
        
        if($delete){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes delete data!'
        ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed delete data!'
        ]);
        }
    }
    //delete data end
}
