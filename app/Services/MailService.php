<?php
namespace App\Services;
use App\Mail\MailRegistration;
use App\Mail\MailOfferRequest;
use App\Mail\MailOfferAssignation;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Log;

class MailService implements IMailService{
    
    public function sendMailRegister($to,$user){
        try{
            Mail::to($to)->send(new MailRegistration($user));
            return true;
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function sendMailOfferRequest($to,$content){
        try{
            Mail::to($to)->send(new MailOfferRequest($content));
            return true;
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function sendMailOfferaAssignation($to,$content){
        try{
            Mail::to($to)->send(new MailOfferAssignation($content));
            return true;
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}


