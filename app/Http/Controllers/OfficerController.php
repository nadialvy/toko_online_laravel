<?php

namespace App\Http\Controllers;

use App\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
    //read data start
    public function show()
    {
        return Officer::all();
    }

    public function detail($id){
        if(Officer::where('officer_id', $id) -> exists()){
            $data_order = DB::table('officer')
            ->select('officer.officer_id', 'officer.name', 'officer.usn', 'officer.pass', 'officer.level')
            ->where('officer_id', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Could not find data']);
        }
    }
    //read data end

    //create data start
    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'usn' => 'required',
                'pass' => 'required',
                'level' => 'required'
            ]
        );

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $simpan = DB::table('officer')
        ->insert([
            'name' => $request->name,
            'usn' => $request->usn,
            'pass' => $request->pass,
            'level' => $request->level
        ]);

        $data = Officer::where('name', '=', $request->name) -> get();
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
}
