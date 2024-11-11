<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferRequest;
use Illuminate\Support\Facades\Log;
use App\Repository\IOfferRequestRepository;
use App\Constants\Constant;

class OfferRequestRepository implements IOfferRequestRepository{


    function list($params){        
        try{
            $conditions = [['offer_requests.status','!=',Constant::DELETED_STATUS]];
            if(array_key_exists("user_id",$params)) 
                $conditions[]=['offer_requests.user_id',$params['user_id']];
            if(array_key_exists("offer_id",$params)) 
                $conditions[]=['offer_requests.offer_id',$params['offer_id']];
            $list = OfferRequest::select('offer_requests.id','offer_requests.status','offer_requests.user_id','offer_requests.offer_id','offer_requests.created_at','offer_requests.updated_at',
                'u.name','u.lastname','u.cellphone','u.email')
                ->join('users as u','u.id','=','offer_requests.user_id')
                ->whereIn('offer_requests.status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS,Constant::COMPLETED_STATUS])
                ->orderBy("offer_requests.created_at","asc")
                ->where($conditions)
                ->paginate();
            return $list;
        } catch (\Exception $e) { 
            throw new \Exception($e->getMessage());
        }        
    }
    function save($data){
        try {
            if( array_key_exists("id",$data) ) {
                OfferRequest::find($data['id'])->update($data);
                $o = OfferRequest::find($data['id']);
            }
            else $o = OfferRequest::create($data);
            $resp = OfferRequest::find($o->id);
            return $resp;
        } catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    function destroy($id){
        try {            
            OfferRequest::find($id)->update(['status'=>0]);
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findById($id) {
        return OfferRequest::find($id);
    }
    
    function offerRequest($id){
        try {
            $user = OfferRequest::find($id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getByOfferAndUserId($offer_id, $user_id){
        try {
            $offer_requests = OfferRequest::select('id','image','status','user_id','offer_id','created_at','updated_at')
            ->where('offer_id',$offer_id)
            ->where('user_id',$user_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS, Constant::COMPLETED_STATUS])
            ->get();
            if($offer_requests->isEmpty()) return null;
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function findByOfferId($offer_id){
        try {
            $offer_requests = OfferRequest::select('id','status','user_id','offer_id','created_at','updated_at')
            ->where('offer_id',$offer_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS, Constant::COMPLETED_STATUS])
            ->get();
            if($offer_requests->isEmpty()) return null;
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getLastOfferRequest($offer_id, $user_id){
        try {
            $offer_assignation = OfferRequest::where('offer_id',$offer_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS])
            ->where('user_id',$user_id)
            ->orderBy('created_at','desc')
            ->first();
            return $offer_assignation;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function markAsUnnasignedOtherRequests($offer_id, $user_id){
        try {
            $offer_requests = OfferRequest::where('offer_id',$offer_id)
            ->where('user_id','!=',$user_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS])
            ->whereNotIn('status',[Constant::REJECTED_STATUS,Constant::DELETED_STATUS])
            ->update(['status'=>Constant::UNNASSGINED_STATUS]);
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function markAsCratedOtherRequests($offer_id, $user_id){
        try {
            $offer_requests = OfferRequest::where('offer_id',$offer_id)
            ->where('user_id','!=',$user_id)
            ->whereIn('status',[Constant::CREATED_STATUS,Constant::EXECUTION_STATUS])
            ->whereNotIn('status',[Constant::REJECTED_STATUS,Constant::DELETED_STATUS])
            ->update(['status'=>Constant::CREATED_STATUS]);
            return $offer_requests;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


