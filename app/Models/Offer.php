<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model{

    public $timestamps = true;
 
    protected $fillable = [
        'name','deadline','user_id','description','price','status','category', 'type','address','rating'
    ];
}