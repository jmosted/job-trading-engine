<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model{

    public $timestamps = true;
 
    protected $fillable = [
        'id','file_name','file_extension','image','user_id','offer_id','status'
    ];


}
