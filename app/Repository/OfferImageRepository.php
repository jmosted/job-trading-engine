<?php
namespace App\Repository;
use App\Models\Offer;
use App\Models\OfferImage;
use Illuminate\Support\Facades\Log;

class OfferImageRepository implements IOfferImageRepository{


    function list($params){        
        try{
            $list = OfferImage::where('status','1')
                ->orderBy("created_at","asc")
                ->paginate();
            return $list;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }        
    }
    function save($data){
        try {
            
        } catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    function destroy($id){
        try {            
            OfferImage::find($id)->update(['status'=>0]);
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findById($id) {
        return OfferImage::find($id);
    }
    
    function offerImage($id){
        try {
            $user = Offer::find($id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getByOfferId($id){
        try {
            $offer_images = OfferImage::select('id','file_name','file_extension','image','status','user_id','offer_id','created_at','updated_at')
            ->where('offer_id',$id)
            ->where('status','1')
            ->get();
            if($offer_images->isEmpty()) return null;
            if ($offer_images->count() == 0) return null;
            foreach ($offer_images as $image) {
                $imageDataUncompressed = gzuncompress($image->image);
                $image->image = base64_encode($imageDataUncompressed);
            }
            return $offer_images;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}


