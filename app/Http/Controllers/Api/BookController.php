<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book=Book::with('user')->orderBy('id','desc')->get();
        return success_response($book,'Book list show successfully',201);
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'title'=>'required',
            'author'=>'required',
            'publisher'=>'required',
            'edition'=>'required',
            'pages'=>'required',
            'country'=>'required',
            'image'=>'required',
        ]);

        if($validator->fails()){
            return error_validation($validator->errors());
        }


        return $this->image_upload($request->image,'books');



        try{
            $book=Book::create([
                'user_id'=>$request->user_id,
                'title'=>$request->title,
                'author'=>$request->author,
                'publisher'=>$request->publisher,
                'edition'=>$request->edition,
                'pages'=>$request->pages,
                'country'=>$request->country,
                'image'=>'ami.png',
            ]);

            return success_response($book,'Book created successfully',201);

        }catch(Exception $e){
            return error_response($e->getMessage(),400);
        }

    }


    public function image_upload($image,$dir){

        $file=explode(';base64,',$image);
        $file1=$file[1];
        $file2=$file[0];
        $ext=explode('/',$file2);
        $extension=end($ext);

        $file_name=uniqid().date('ymdhis').'.'.$extension;


        $trim=str_replace(',','',$file1);

        Storage::disk('public')->put($dir.'/'.$file_name,base64_decode($trim));

    }


    public function show($id)
    {
        $book=Book::with('user')->find($id);
        if($book){
            return success_response($book,'Book show successfully',201);

        }else{
            return error_response('opps not show the Book',400);
        }
    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book=Book::find($id);
        if($book){
            $book->delete();
            return success_response($book,'successfully delete Book',201);

        }else{
            return error_response('not possible to update Book',400);

        }
    }
}
