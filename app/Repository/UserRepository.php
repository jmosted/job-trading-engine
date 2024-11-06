<?php
namespace App\Repository;
use App\Models\User;

class UserRepository implements IUserRepository{

    function list($params)
    {     
        try{
            $list = User::paginate();
            return $list;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }        
    }
    function save($data)
    {
        try {
                //Solo se actualiza
                if( array_key_exists("id",$data) ){
                    if (array_key_exists('password',$data) ) {
                        $data['password'] = app('hash')->make($data['password']);
                    }
                    User::find($data['id'])->update($data);
                    $o = User::find($data['id']);
                    return $o;
                }
            }
        catch (\Exception $e)
            {
            throw new \Exception($e->getMessage());
            }
    }

    function destroy($id)
    {
        try {
            User::find($id)->delete();
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function user($id){
        try {
            $user = User::find($id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


