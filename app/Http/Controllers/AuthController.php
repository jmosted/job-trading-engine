<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Repository\Auth\IAuthRepository;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;
use App\Utils\GenerateId;
use \Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    //private $repository;
    
    public function __construct()
    {
        //$this->repository=$repository;
    }

    public function googleRegister(Request $request){

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'google_id' => 'required|string',
            'img' => 'required|string',
        ]);
        //dd($request);
        try {

            $user = new User;
            //$user->name = $request->input('username');
            $user->username=$request->input('email');
            $user->google_id = $request->input('google_id');
            $user->img = $request->input('img');
            $user->password = app('hash')->make($request->input('google_id'));
            $user->email = $request->input('email');
            $user->save();
            $client = new Client;
            $client->name = $request->input('name');
            $client->lastname = $request->input('lastname');
            $client->user_id = $user->id;
            $client->currency = 'PEN';
            $client->document="11111111";
            $client->save();
            return response()->json(['user' => $user, 'message' => 'USER CREATED','value'=>true], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['error'=>$e ,'message' => 'User Registration Failed!'], 409);
        }
    }

    public function register(Request $request){
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'identification_number' => 'required|string',
                'identification_type' => 'required|string',
                'favorite_phrase' => 'required|string',
                'cellphone' => 'required|string'
            ]);
            //dd($request);
            $user = User::where('email', $request->input('email'))->first();
            if ($user) {
                return response()->json(['error' => true, 'code' => 10, 'data' => null, 'type' => '1','msg'=>'Email ya fue registrado'], 404);
            }

            $user_register = new User;
            $user_register->id = GenerateId::generateUuidV4();
            $user_register->email = $request->input('email');
            $user_register->username = $request->input('email');
            $user_register->name = $request->input('name');
            $user_register->lastname = $request->input('lastname');
            $user_register->identification_number = $request->input('identification_number');
            $user_register->identification_type = $request->input('identification_type');
            $user_register->favorite_phrase = $request->input('favorite_phrase');
            $plainPassword = $request->input('password');
            $user_register->password = app('hash')->make($plainPassword);
            $user_register->cellphone = $request->input('cellphone');
            $user_register->save();
            $user = User::where('email', $request->input('email'))->first();
            return response()->json(['error' => false, 'code' => 29,'data' => ['user'=> $user_register], 'type'=>'1','msg' => 'Procesado correctamente'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['error' => true, 'code' => 10, 'data' => null, 'type' => '1','msg'=>$e], 409);
        }

    }

    public function login(Request $request) {
        try {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only(['email', 'password']);
            $ttl=7200;
            $token = Auth::setTTL($ttl)->attempt($credentials);
            if (! $token) {
                return response()->json(['error' => true, 'code' => 10, 'data' => null, 'type' => '1','msg'=>'Usuario no autorizado'],403);
            }
            return $this->respondWithToken($token,$credentials['email']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'code' => 10, 'data' => null, 'type' => '1','msg'=>$e], 409);
        }
    }

    public function googleLogin(Request $request) {

        try {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only(['email', 'password']);
          
            $ttl=7200;
            if (! $token = Auth::setTTL($ttl)->attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized',  'credentials'=>$credentials, 'token'=>$token ],403);
            }
            return $this->respondWithToken($token,$credentials['email']);
        } catch (\Exception $e) {
            return response()->json(['error'=>"GOOGLE_LOGIN_FAILED" ,'message' => $e], 409);
        }
        
    }

    public function logout(){
        Auth::logout();
        return response()->json(['status'=>true]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        //return $this->respondWithToken(auth()->refresh());
    }

}   