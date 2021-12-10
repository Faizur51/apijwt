<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
class UserController extends Controller
{

    public function index()
    {
        $user=User::select('id','name','email')->orderBy('id','desc')->get();
        return success_response($user,'user list show successfully',201);
    }


    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required|min:4|max:50',
            'email'=>'required|unique:users',
            'password'=>'required|min:4|max:8',
        ]);

        if($validator->fails()){
                  return error_validation($validator->errors());
        }

        try{
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            return success_response($user,'user created successfully',201);

        }catch(Exception $e){
            return error_response('Something went worng',400);
        }

    }

    public function show($id)
    {
       $user=User::find($id);
       if($user){
           return success_response($user->only('id','email','name'),'user show successfully',201);

       }else{
           return error_response('opps not show the user',400);
       }

    }


    public function update(Request $request, $id)
    {

        $user=User::find($id);

        if($user){
            $validator=Validator::make($request->all(),[
                'name'=>'required|string',
            ]);

            if($validator->fails()){
                return error_validation($validator->errors());
            }

            try{
                $user->name=$request->name;
                $user->update();
                return success_response($user->only('id','email','name'),'user update succesfully',201);

            }catch(Exception $e){

                return error_response('user update not succesfully',400);

            }

        }else{
            return response()->json([
                'status'=>false,
                'message'=>'user not found'
            ]);
        }
    }


    public function destroy($id)
    {
        $user=User::find($id);
        if($user){
            $user->delete();
            return success_response($user->only('id','email','name'),'successfully delete user',201);

        }else{
            return error_response('not possible to update user data ',400);

        }
    }
}
