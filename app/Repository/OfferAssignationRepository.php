<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferAssignation;
use Illuminate\Support\Facades\Log;
use App\Repository\IOfferAssignationRepository;
use App\Constants\Constant;

class OfferAssignationRepository implements IOfferAssignationRepository{


    function list($params){        
        try{
            $conditions = [['offer_assignations.status','!=',Constant::DELETED_STATUS]];
            if(array_key_exists("user_id",$params)) 
                $conditions[]=['offer_assignations.user_id',$params['user_id']];
            if(array_key_exists("offer_id",$params)) 
                $conditions[]=['offer_assignations.offer_id',$params['offer_id']];
            $list = OfferAssignation::select('offer_assignations.id','offer_assignations.status','offer_assignations.user_id','offer_assignations.offer_id','offer_assignations.created_at','offer_assignations.updated_at',
                'u.name','u.lastname','u.cellphone','u.email')
                ->whereIn('offer_assignations.status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS,Constant::COMPLETED_STATUS])
                ->join('users as u','u.id','=','offer_assignations.user_id')
                ->where('offer_assignations.status','!=', Constant::DELETED_STATUS)
                ->where('offer_assignations.status','!=',Constant::REJECTED_STATUS)
                ->where($conditions)
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
            $resp = OfferAssignation::find($o->id);
            return $resp;
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
            $offer_requests = OfferAssignation::select('id','status','user_id','offer_id','created_at','updated_at')
            ->where('offer_id',$id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS,Constant::COMPLETED_STATUS])
            ->orderBy('created_at','desc')
            ->first();
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getLastOfferAssignation($offer_id, $user_id){
        try {
            $offer_assignation = OfferAssignation::where('offer_id',$offer_id)
            ->where('user_id',$user_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS,Constant::COMPLETED_STATUS])
            ->orderBy('created_at','desc')
            ->first();
            return $offer_assignation;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


