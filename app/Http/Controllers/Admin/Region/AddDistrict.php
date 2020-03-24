<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\DistrictData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\DistrictAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class AddDistrict extends Controller
{
    protected $validateArray=[
        "data.name"=>"required",
        "data.cityid"=>"required",
        "data.cityName"=>"required",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入区名",
        "data.cityid.required"=>"请输入城市id",
        "data.cityName.required"=>"请输入城市名",
    ];

    /**
     * 添加区
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new DistrictData();
        $adapter = new DistrictAdapter();

        $district = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $district, $model);
        $data->save($model);
        
        $this->Success();
    }
}
