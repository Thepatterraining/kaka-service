<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\DistrictData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\DistrictAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class SaveDistrict extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "data.name"=>"required",
        "data.cityid"=>"required",
        "data.cityName"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入区id",
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
        $id = $this->request->input('id');

        $data = new DistrictData();
        $adapter = new DistrictAdapter();

        $district = $adapter->getData($this->request);
        $model = $data->get($id);
        $adapter->saveToModel(false, $district, $model);
        $data->save($model);
        
        $this->Success();
    }
}
