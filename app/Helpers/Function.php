<?php


function error_validation($errors,$code=422){
    return response()->json([
        'status'=>false,
        'message'=>$errors
    ],$code);
}



function success_response($data,string $message,int $code=201){
    return response()->json([
        'status'=>true,
        'data'=>$data,
        'message'=>$message
    ],$code);
}


function error_response(string $message,int $code=400){
    return response()->json([
        'status'=>false,
        'message'=>$message
    ],$code);
}
