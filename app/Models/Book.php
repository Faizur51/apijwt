<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable =['user_id', 'title', 'author', 'publisher', 'edition', 'pages', 'country', 'image'];


    public  function user(){
        return $this->belongsTo(User::class)->select('id','name','email');
    }

}





