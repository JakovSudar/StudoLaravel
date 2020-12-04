<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

    private function successResponse($data,$code){
        return response()->json($data,$code);
    }

    protected function returnAll(Collection $data,$code=200){
        $data = $this->filterData($data);

        return $this->successResponse(['data'=>($data)],$code);
        //return $this->successResponse(($data),$code);
    }

    protected function returnOne(Model $instance,$code = 200){
        return $this->successResponse($instance,$code);
    }


    protected function filterData(Collection $collection)
    {
        foreach(request()->query() as $query => $value){
            if(isset($query,$value)){
                if($query == "wage"){
                    $collection = $collection->where($query,'>=',$value);
                }else{
                    $collection = $collection->where($query,$value);
                }
            }
        }
        $arr = [];
        foreach($collection as $job){
            $arr[]=$job;
        }
        return $arr;
    }
}
