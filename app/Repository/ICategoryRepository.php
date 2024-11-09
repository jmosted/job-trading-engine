<?php
namespace App\Repository;

interface ICategoryRepository{
    public function list($params);
    public function save($params);
    public function destroy($params);
}