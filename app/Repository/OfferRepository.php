<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferImage;
use Illuminate\Support\Facades\Log;
use App\Constants\Constant;

class OfferRepository implements IOfferRepository{


    function list($params){        
        try{
            $conditions = [['offers.status','!=',Constant::DELETED_STATUS]];
            if(array_key_exists("user_id",$params)) 
                $conditions[]=['offers.user_id',$params['user_id']];
            $list = Offer::where('status','1')
                ->where('user_id',$params['user_id'])
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
            $offer_image = $data['image_data'];
            //Log::info("Guardar oferta",$data);
            unset($data['image_data']);
            if( array_key_exists("id",$data) ) {
                Offer::find($data['id'])->update($data);
                $o = Offer::find($data['id']);
            }
            else $o = Offer::create($data);
            if (array_key_exists("id",$data)) {
                return $o;
            }
            foreach ($offer_image as $image) {
                if (!$image['image'] || ( $image['image'] && $image['image'] == '')) {
                    continue;
                } 
                $image_base64 = base64_decode($image['image']);
                $compressedImageData = gzcompress($image_base64);
                //$image['image']='';
                $image['image']=$compressedImageData;
                if ($image && array_key_exists("id", $image)) {
                    OfferImage::find($image['id'])->update($image);
                } else {
                    $image["offer_id"] = $o->id;
                    $image["user_id"] = $data['user_id'];
                    OfferImage::create($image);
                }
            }

            $image_data = OfferImage::where('offer_id', $o->id)->orderBy('created_at', 'desc')->first();
            //$o['image_data'] = $image_data;
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

    public function getCompleted($user_id) {
        try {
            $list = Offer::select('offers.id','offers.rating','oa.user_id','oa.created_at as fecha_asignacion')
                ->join('offer_assignations as oa','oa.offer_id','=','offers.id')
                ->where('offers.status',Constant::COMPLETED_STATUS)
                ->where('oa.user_id',$user_id)
                ->orderBy("offers.created_at","asc")
                ->get();
            return $list;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public  function getActive($user_id) {
        try {
            $list = Offer::select('offers.id','oa.user_id','oa.created_at as fecha_asignacion')
                ->join('offer_assignations as oa','oa.offer_id','=','offers.id')
                ->where('status',Constant::EXECUTION_STATUS)
                ->where('oa.user_id',$user_id)
                ->orderBy("created_at","asc")
                ->get();
            return $list;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


