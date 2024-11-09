<?php
namespace App\Repository;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements ICategoryRepository{


    function list($params){        
        try{
            $list = Category::where('status','1')->get();
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
            Offer::find($id)->update(['status'=>0]);
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findById($id) {
        return Offer::find($id);
    }
}


