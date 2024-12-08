<?php
namespace App\Services;

interface IOfferService{
    public function list($params);
    public function save($payload);
    public function requestOffer($id);
    public function assignOffer($id);
    public function rejectRequestOffer($id);
    public function rejectAssignOffer($id);
    public function destroyRequestOffer($id);
    public function destroyAssignOffer($id);
}