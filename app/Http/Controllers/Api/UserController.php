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
        return response()->json([
               'data'=>$user,
                'status'=>true,
              'message'=>'successfully show the  User list'
        ],201);
    }


    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required|min:4|max:50',
            'email'=>'required|unique:users',
            'password'=>'required|min:4|max:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>true,
                'message'=>$validator->errors()
            ]);
        }

        try{
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            return response()->json([
                'status'=>true,
                'data'=>$user->only('name','email'),
                'message'=>'User create successfully'
            ]);

        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'something went worng'
            ]);
        }

    }

    public function show($id)
    {
       $user=User::find($id);
       if($user){
           return response()->json([
               'status'=>true,
               'data'=>$user->only('id','email','name'),
               'message'=>'succesfully show the user'
           ],201);
       }else{
           return response()->json([
               'status'=>false,
               'message'=>'opps not show the user'
           ]);
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
                return response()->json([
                    'status'=>true,
                    'message'=>$validator->errors()
                ]);
            }

            try{
                $user->name=$request->name;
                $user->update();
                return response()->json([
                    'status'=>true,
                    'data'=>$user->name,
                    'message'=>'user update succesfully'
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>'user update not succesfully'
                ]);
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
            return  response()->json([
                'status'=>true,
                 'message'=>'successfully delete user'
          ]);
        }else{
            return  response()->json([
                'status'=>false,
                'message'=>'not possible to delete user'
            ]);
        }
    }
}
