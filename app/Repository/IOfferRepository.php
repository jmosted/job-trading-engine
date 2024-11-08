<?php
namespace App\Repository;

interface IOfferRepository{
    public function list($params);
    public function offer($params);
    public function save($params);
    public function destroy($params);
    public function findById($id);
}