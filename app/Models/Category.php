<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{

    public $timestamps = true;
 
    protected $fillable = [
        'name','status','created_at','updated_at'
    ];
}