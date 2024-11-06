<?php
namespace App\Services;

interface IUserService{
    public function getByToken($token);
    public function getByEmail($email);
}