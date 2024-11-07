<?php
namespace App\Services;

interface IOfferService{
    public function list($params);
    public function save($payload);
    public function requestOffer($id);
    public function assignOffer($id);
}