<?php
namespace App\Repository\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailForPass;
use Illuminate\Support\Facades\Storage;
use App\Services\IForgotPasswordService;

class AuthRepository implements IAuthRepository{
   
    private $forgotpaswordService;
    public function __construct(IForgotPasswordService $forgotpaswordService)
    {
        $this->forgotpaswordService = $forgotpaswordService;
        
    }
    function login($params,$ip_addres){
        try {
                $login =$this->Auth($params);
                if($login==false){
                    $resp = $this->saveIpAddresAndTriedLogin($ip_addres);
                    return $resp ;
                }
                else{
                    return $login;
                }
                
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function Auth($params){
        $resp = Http::get('https://my-json-server.typicode.com/brianpando/mockJsonServer/clients');
                $list = $resp->json();
                for ($i=0; $i < count($list) ; $i++) { 
                    if($list[$i]['email']==$params['email'] && $list[$i]['password'] == $params['password'])
                    {
                        return $list[$i];
                    }
                }
                return false ;
    }
    function logout($params){
        $logout="";
        $aux_route =dirname(__DIR__,3);
        $route = $aux_route."/storage/docs";
        if(file_exists($route.'/ip_addres.txt')){
            $logout = unlink($route.'/ip_addres.txt');
            return $logout;
        }
        else{

            return $logout;
        }
    }
    function forgot_password($params){
        $resp = $this->forgotpaswordService->send($params);
        return $resp ;
    }
    function validateCaptcha($params){
        $secretKey = "";
    }
    function saveIpAddresAndTriedLogin($ip_addres){
        $aux_route =dirname(__DIR__,3);
        $route = $aux_route."/storage/docs";
        $tried_aux=null;
        $tried=1;
        $ip ="";
        if(file_exists($route.'/ip_addres.txt')){
            $value = file_get_contents($route.'/ip_addres.txt');
            for ($i=0; $i < strlen($value) ; $i++) { 
                if($value[$i]=="/"){
                    $tried_aux = $value[$i+1];
                    $tried = $tried_aux+1 ;
                    break;
                }
                else{
                $ip = $ip.$value[$i];
                }
            }
            $value = $ip."/".$tried ;
            file_put_contents($route.'/ip_addres.txt', $value);
            $data=[
                'address_ip'=>$ip,
                'intentos'  =>(int)($tried)
            ];
            return $data;
        }
        else{
            return $this->catchTriedAndIp($ip_addres);
        } 
    }
    function saveIpUpdatePage($ip_addres){
        $aux_route =dirname(__DIR__,3);
        $route = $aux_route."/storage/docs";
        $tried=1;
        $ip ="";
        if(file_exists($route.'/ip_addres.txt')){
            $value = file_get_contents($route.'/ip_addres.txt');
            for ($i=0; $i < strlen($value) ; $i++) { 
                if($value[$i]=="/"){
                    $tried = $value[$i+1];
                    break;
                }
                else{
                $ip = $ip.$value[$i];
                }
            }
            $value = $ip."/".$tried ;
            file_put_contents($route.'/ip_addres.txt', $value);
            $data=[
                'address_ip'=>$ip,
                'intentos'  =>(int)($tried)
            ];
            return $data;
        }
        else{
            return $this->catchTriedAndIp($ip_addres);
        } 
    }
    function catchTriedAndIp($params){
        $aux_route =dirname(__DIR__,3);
        $route = $aux_route."/storage/docs";
        $init=1;
        $data = $params."/".$init ;
        
        file_put_contents($route.'/ip_addres.txt', $data);
        $datas=[
            'address_ip'=>$params,
            'intentos'=>$init
        ];
        return $datas;
    }
    
    function readFile(){
        $tried="";
        $ip="";
        $value=[];
        $aux_route = dirname(__DIR__,3);
        $route = $aux_route."/storage/docs";
        if(file_exists($route.'/ip_addres.txt')){
            $data = file_get_contents($route.'/ip_addres.txt') ;
            for ($i=0; $i < strlen($data) ; $i++) { 
                if($data[$i]=="/"){
                    $tried = $data[$i+1];
                    break;
                }
                else{
                    $ip=$ip.$data[$i];
                }
            }
            $value=[
                'tried' =>$tried,
                'ip'=>$ip
            ];
            return $value;
        }

        return false;
    }
    
}