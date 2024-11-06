<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferRequest extends Model{

    public $timestamps = true;
 
    protected $fillable = [
        'id','name','user'
    ];


}
