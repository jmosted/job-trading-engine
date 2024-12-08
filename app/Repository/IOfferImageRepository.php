<?php
namespace App\Repository;

interface IOfferImageRepository{
    public function list($params);
    public function save($params);
    public function destroy($params);
    public function offerImage($params);
    public function getByOfferId($params);
}