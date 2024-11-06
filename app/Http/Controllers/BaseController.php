<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller {
    const BAD_REQUEST_CODE = 400;
    const INTERNAL_SERVER_ERROR_CODE = 500;
    public function tokenFromHeaders(Request $request) {
        $authorization = $request->header('Authorization');
        $token = explode(" ", $authorization)[1];
        return $token;
    }

    public function handleErrorResponse(\Exception $e) {
        $code = $e->getCode()==self::BAD_REQUEST_CODE ? $e->getCode() : self::INTERNAL_SERVER_ERROR_CODE;
        return response()->json(['error' => true, 'code' => 29,'data' => null, 'type'=>'1','msg' => $e->getMessage()],$code);
    }
}