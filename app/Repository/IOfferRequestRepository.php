<?php
namespace App\Repository;

interface IOfferRequestRepository{
    public function list($params);
    public function offerRequest($params);
    public function save($params);
    public function destroy($params);
    public function getByOfferId($offr_id, $user_id);
    public function getLastOfferRequest($offer_id,$user_id); 
}