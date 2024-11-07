<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferAssignation extends Model{

    public $timestamps = true;
 
    protected $fillable = [
        'id','user_id','offer_id','status'
    ];

}
