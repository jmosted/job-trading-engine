<?php
namespace App\Repository;

interface IOfferRequestRepository{
    public function list($params);
    public function offerRequest($params);
    public function save($params);
    public function findById($id);
    public function destroy($params);
    public function getByOfferAndUserId($offer_id, $user_id);
    public function findByOfferId($offer_id);
    public function getLastOfferRequest($offer_id,$user_id); 
    public function markAsUnnasignedOtherRequests($offer_id, $user_id);
    public function markAsCratedOtherRequests($offer_id, $user_id);
}