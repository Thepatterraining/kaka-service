<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaylineData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaylineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class SaveSubwayline extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "data.name"=>"required",
        "data.cityid"=>"required",
        "data.cityName"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入地铁线id",
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
        $id = $this->request->input('id');

        $data = new SubwaylineData();
        $adapter = new SubwaylineAdapter();

        $subwayline = $adapter->getData($this->request);
        $model = $data->get($id);
        $adapter->saveToModel(false, $subwayline, $model);
        $data->save($model);
        
        $this->Success();
    }
}
