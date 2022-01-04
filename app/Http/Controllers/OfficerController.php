<?php

namespace App\Http\Controllers;

use App\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
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

        if($simpan){
            return Response() -> json(['status' => 1]);
        } else {
            return Response() -> json(['status' => 0]);
        }
    }
    //create data end
}
