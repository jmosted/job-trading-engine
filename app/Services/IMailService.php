<?php
namespace App\Services;

interface IMailService{

    public function sendMailRegister($to,$user);
    public function sendMailOfferRequest($to,$offer_request);
    public function sendMailOfferaAssignation($to,$offer_assignation);
}