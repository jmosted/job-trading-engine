<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token,$email)
    {
        return response()->json(['error' => false, 'code' => 29,'data' => ['token' => $token,'token_type' => 'bearer','expires_in' => Auth::factory()->getTTL() * 60], 'type'=>'1','msg' => 'Procesado correctamente'], 200);
    }
}
