<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class UserController extends Controller
{
    public function login(Request $request) //function login
    {
        $credentials = $request->only('email', 'password'); 
        //hal diatas sama saja dengan 'email' -> $request, 'password' -> $request

        try{
            if( ! $token = JWTAuth::attempt($credentials)) {//jwt auth akan mengquery/cek apakah ada atau tidak
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
        }catch(JWTException $e) {
            return response()->json(['error' => 'Couldnt create token'], 500);
        }

        $data = User::where('email', '=', $request->email)-> get();
        return response()->json([
            'status' => 1,
            'message' => 'Succes login!',
            'token' => compact('token'),
            'data' => $data
        ]);
    }


    public function register(Request $request)
    {
        $validator=Validator::make($request->all(), 
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', //unique untuk mengecek, users adalah nama tabel
                                                                    //ketika validator, sebelum insert data, akan dicek apakah email nya sudah ada di tabel user
                                                                    //jadi tidak boleh ada email yang samma
            'password' => 'required|string|min:6|confirmed', //confirmed artinya harus ada password confirmation
        ]);

        if($validator->fails()){
            return response() -> json($validator->errors()->toJson(), 400);
        }
        
        $user=User::create(
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]
        );

        $token=JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }


    public function getAuthenticatedUser(){//function untuk memvalidasi token, apakah token masih berlaku, aoakah
                                            //kenapa perlu di terjemahkan, agar frontend tau, jika tokennya admin, maka ui nya beda dengan pelanggan
        try{
        if( ! $user=JWTAuth::parseToken()->authenticate() ){
                return response() -> json(['user not found'], 400);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return Response()->json(['token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return Response()->json(['token_invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            return Response()->json(['token_absent'], 401);
        }

        return Response()->json(compact('user'));//return tabel user
    }
}
