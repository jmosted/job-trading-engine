<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferImage;
use Illuminate\Support\Facades\Log;

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
            $offer_image = $data['image_data'];
            Log::info("Guardar oferta",$data);
            unset($data['image_data']);
            if( array_key_exists("id",$data) ) {
                Offer::find($data['id'])->update($data);
                $o = Offer::find($data['id']);
            }
            else $o = Offer::create($data);

            if($offer_image && array_key_exists("id",$offer_image) ){
                OfferImage::find($data['id'])->update($data);
            }else{
                $offer_image["offer_id"]=$o->id;
                $offer_image["user_id"]=$data['user_id'];
                OfferImage::create($offer_image);
            }

            $image_data = OfferImage::where('offer_id', $o->id)->orderBy('created_at', 'desc')->first();
            $o['image_data'] = $image_data;
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


