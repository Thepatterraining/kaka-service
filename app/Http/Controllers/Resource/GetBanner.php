<?php

namespace App\Http\Controllers\Resource;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\Resource\ResourceBannerpicData;

class GetBanner extends Controller
{
    const MODEL_TYPE='application';

    protected $validateArray=[
        // "index"=>"required",
    ];
    protected $validateMsg=[
        // "index.required"=>"请输入轮播图索引",
    ];
    public function run()
    {

        $request=$this->request->all();
        // $index=$request['index'];
        $appId=$this->session->appid;
        $resourceBannerpicData=new ResourceBannerpicData();
        $modelType=self::MODEL_TYPE;
        $res=$resourceBannerpicData->getBannerHandle($modeType, $appId);
        return $res;
    }
}