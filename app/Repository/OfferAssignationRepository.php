<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferAssignation;
use Illuminate\Support\Facades\Log;
use App\Repository\IOfferAssignationRepository;

class OfferAssignationRepository implements IOfferAssignationRepository{


    function list($params){        
        try{
            $list = OfferAssignation::where('status','1')
                ->where('status','2')
                ->where('status','3')
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
                OfferAssignation::find($data['id'])->update($data);
                $o = OfferAssignation::find($data['id']);
            }
            else $o = OfferAssignation::create($data);
            return $o;
        } catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    function destroy($id){
        try {            
            OfferAssignation::find($id)->update(['status'=>0]);
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findById($id) {
        return OfferAssignation::find($id);
    }
    
    function offerAssignation($id){
        try {
            $user = Offer::find($id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function findByOfferId($id){
        try {
            $offer_requests = OfferAssignation::select('id','image','status','user_id','offer_id','created_at','updated_at')
            ->where('offer_id',$id)
            ->whereIn('status',[1,2,3])
            ->get();
            if($offer_requests->isEmpty()) return null;
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getLastOfferAssignation($offer_id, $user_id){
        try {
            $offer_assignation = OfferAssignation::where('offer_id',$offer_id)
            ->where('user_id',$user_id)
            ->whereIn('status',[1,2,3])
            ->orderBy('created_at','desc')
            ->first();
            return $offer_assignation;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


