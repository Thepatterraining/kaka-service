<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\System\Resource\Data\ResourceStoreData;
use App\System\Resource\Data\ResourceIndexData;

class CreateResourceStore extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入索引id",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];

        $data=new ResourceStoreData();
        $resourceIndexData=new ResourceIndexData();
        $define=$data->newitem()->where('id', $id)->first();
        if(!empty($define)) {
            $indexInfo=$resourceIndexData->newitem()->where('resource_id', $id)->first();
            if($indexInfo) {
                $data->delete($id); 
            }
        }
        return $this->Success();
    }
}
