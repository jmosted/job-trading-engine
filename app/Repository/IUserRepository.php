<?php
namespace App\Repository;

interface IUserRepository{
    public function list($params);
    public function save($params);
    public function destroy($params);
    public function user($params);
}