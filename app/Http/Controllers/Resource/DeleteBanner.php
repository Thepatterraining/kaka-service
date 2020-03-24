<?php

namespace App\Http\Controllers\Resource;

use App\Data\Queue\QueueHandleData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Resource\ResourceBannerpicData;

class DeleteBanner extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入轮播图信息id",
    ];


    /**
     * 队列信息回调操作
     *
     * @param   queue string 队列名称
     * @author  liu
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $id=$request['id'];
        $resourceBannerpicData=new ResourceBannerpicData();
        $bannerInfo=$resourceBannerpicData->get($id);
        if($bannerInfo) {
            $resourceBannerpicData->newitem()->where('id', $id)->delete();
        }
        return $this->success("success");
    }
}
