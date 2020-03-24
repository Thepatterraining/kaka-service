<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\CityData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\CityAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetCity extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入城市id",
    ];

    /**
     * 添加城市
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new CityData();
        $adapter = new CityAdapter();

        $city = $data->get($id);
        
        $city = $adapter->getDataContract($city);
        
        $this->Success($city);
    }
}
