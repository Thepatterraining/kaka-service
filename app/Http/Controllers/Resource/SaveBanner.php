<?php

namespace App\Http\Controllers\Resource;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\Resource\ResourceBannerpicData;

class SaveBanner extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "name"=>"required",
        "resourceid"=>"required",
        "modeldefineid"=>"required",
        "modeldefinedataid"=>"required",
        "showlevel"=>"required",
    ];
    protected $validateMsg=[
        "id.required"=>"请输入id",
        "name.required"=>"请输入轮播图名称",
        "resourceid.required"=>"请输入相应资源名称",
        "modeldefineid.required"=>"请输入模型定义id",
        "modeldefinedataid.required"=>"请输入资源数据id",
        "showlevel.required"=>"请输入展示优先级",
    ];
    public function run()
    {
        $request=$this->request->all();
        $id=$request['id'];
        $name=$request['name'];
        $resourceId=$request['resourceid'];
        $index=$request['index'];
        $modelDefineId=$request['modeldefineid'];
        $modelDefineDataId=$request['modeldefinedataid'];
        $resModelDefineId=$request['resmodeldefineid'];
        $resModelDataId=$request['resmodeldataid'];
        $resUrl=$request['resurl'];
        $level=$request['showlevel'];
        $note=$request['note'];
        $resourceBannerpicData=new ResourceBannerpicData();
        $res=$resourceBannerpicData->changeBannerpic($id, $resourceId, $index, $modelDefineId, $modelDefineDataId, $resModelDefineId, $resourceModelDataId, $resUrl, $name, $level, $note);
        return $res;
    }
}