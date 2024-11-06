<?php
namespace App\Services;
use App\Repository\IClientRepository;
use App\Repository\IUserRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;

class UserService implements IUserService{

    private $repository;
    private $clientRepository;

    public function __construct(IUserRepository $repository){
        $this->repository=$repository;
    }

    public function getByToken($token){
        try{
            $credentials = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
            $user=$this->repository->user($credentials->sub);
            $response=compact('user');
            return $response; 
        }catch(\Exception $e){
            throw $e;
        }       
    }

    public function getByEmail($email) {
        $user = $this->repository->findByEmail($email);
        if (is_null($user)) return $user;
        $response=compact('user');
        return $response;
    }
}