<?php
namespace App\Services;

interface IOfferService{
    public function list($params);
    public function save($payload);
}