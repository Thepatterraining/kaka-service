<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaystationData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaystationAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class SaveSubwaystation extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "data.name"=>"required",
        "data.cityid"=>"required",
        "data.cityName"=>"required",
        "data.districtid"=>"required",
        "data.districtName"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入地铁站id",
        "data.name.required"=>"请输入站名",
        "data.cityid.required"=>"请输入城市id",
        "data.cityName.required"=>"请输入城市名",
        "data.districtid.required"=>"请输入区id",
        "data.districtName.required"=>"请输入区名",
    ];

    /**
     * 添加地铁站
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new SubwaystationData();
        $adapter = new SubwaystationAdapter();

        $subwaystation = $adapter->getData($this->request);
        $model = $data->get($id);
        $adapter->saveToModel(false, $subwaystation, $model);
        $data->save($model);
        
        $this->Success();
    }
}
