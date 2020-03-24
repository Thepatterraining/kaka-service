<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\CityData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\CityAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class AddCity extends Controller
{
    protected $validateArray=[
        "data.name"=>"required",
        "data.fullName"=>"required",
        "data.shortName"=>"required",
        "data.provinceid"=>"required",
        "data.provinceName"=>"required",
        "data.country"=>"required",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入城市名",
        "data.fullName.required"=>"请输入城市全名",
        "data.shortName.required"=>"请输入城市简称",
        "data.provinceid.required"=>"请输入省id",
        "data.provinceName.required"=>"请输入省名",
        "data.country.required"=>"请输入国家编号",
    ];

    /**
     * 添加城市
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CityData();
        $adapter = new CityAdapter();

        $city = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $city, $model);
        $data->save($model);
        
        $this->Success();
    }
}
