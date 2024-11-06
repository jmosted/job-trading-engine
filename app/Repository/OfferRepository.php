<?php
namespace App\Repository;
use App\Models\Offer;

class OfferRepository implements IOfferRepository{


    function list($params){        
        try{
            $list = Offer::where('status','1')
                ->orderBy("created_at","asc")
                ->paginate();
            return $list;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }        
    }
    function save($data){
        try {
            if( array_key_exists("id",$data) ) {
                Offer::find($data['id'])->update($data);
                $o = Offer::find($data['id']);
            }
            else $o = Offer::create($data);
            return $o;
        } catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    function destroy($id){
        try {            
            Offer::find($id)->update(['status'=>0]);
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findById($id) {
        return Offer::find($id);
    }
    
    function offer($id){
        try {
            $user = Offer::find($id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


