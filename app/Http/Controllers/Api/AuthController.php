<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return error_validation($validator->errors());
        }

       $credentials =$request->only('email','password');

       if($token=auth()->attempt($credentials)) {
           return response()->json([
               'token'=>$token,
               'data'=>auth()->user()->email,
               'token_type' => 'bearer',
               'expires_in' => auth()->factory()->getTTL() * 60
           ]);
       }else{
           return response()->json('Token not found');
       }
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
