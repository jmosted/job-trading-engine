<?php
namespace App\Repository\Auth;

interface IAuthRepository{

    public function login($params,$ip);
    public function logout($params);
    public function validateCaptcha($params);
    public function readFile();
    public function forgot_password($params);

}