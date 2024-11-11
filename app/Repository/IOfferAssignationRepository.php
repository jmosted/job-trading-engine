<?php
namespace App\Repository;

interface IOfferAssignationRepository{
    public function list($params);
    public function offerAssignation($params);
    public function save($params);
    public function destroy($params);
    public function findByOfferId($id);
    public function getLastOfferAssignation($offer_id,$user_id);
}