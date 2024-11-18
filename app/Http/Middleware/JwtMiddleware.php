<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class JwtMiddleware 
{
    public function handle($request, Closure $next, $guard = null)
    {
        $authorization = $request->header('Authorization');
        $parts = explode(" ",$authorization);
        $token = "";
        if (count($parts)==2) $token = $parts[1];
        if(!$token){ 
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => 'TOKEN_NOT_PROVIDED'],401);
        }
        try {
            $credentials = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => 'TOKEN_EXPIRED'],401);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => 'An error while decoding token.'],401);
        }
        try {
            $user = User::find($credentials->sub);
            $request->auth = $user;
        } catch (Exception $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],401);
        }
        return $next($request);
    }
}