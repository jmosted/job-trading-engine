<?php
namespace App\Services;
use App\Mail\MailRegistration;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Log;

class MailService implements IMailService{
    
    public function sendMailRegister($to,$user){
        try{
            log:info('Nombre'.$user->name);
            Mail::to($to)->send(new MailRegistration($user));
            log::info('A: '.$to);
            return true;
        } catch(\Exception $e){
            log::info('sending mail3 '.$e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function sendMailOfferRequest($to,$content){
        try{
            Mail::to($to)->send(new MailRegistration($content));
            return true;
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function sendMailOfferaAssignation($to,$content){
        try{
            Mail::to($to)->send(new MailRegistration($content));
            return true;
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}


