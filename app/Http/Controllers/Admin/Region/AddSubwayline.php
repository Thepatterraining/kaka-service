<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaylineData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaylineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class AddSubwayline extends Controller
{
    protected $validateArray=[
        "data.name"=>"required",
        "data.cityid"=>"required",
        "data.cityName"=>"required",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入线路名",
        "data.cityid.required"=>"请输入城市id",
        "data.cityName.required"=>"请输入城市名",
    ];

    /**
     * 添加地铁线路
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new SubwaylineData();
        $adapter = new SubwaylineAdapter();

        $subwayline = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $subwayline, $model);
        $data->save($model);
        
        $this->Success();
    }
}
