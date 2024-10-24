<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = ['name','author','price','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
