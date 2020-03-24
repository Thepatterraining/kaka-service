<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\ProvinceData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\ProvinceAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetProvince extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入省id",
    ];

    /**
     * 添加省
     *
     * @param   $name 省名
     * @param   $country 国家编号
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new ProvinceData();
        $adapter = new ProvinceAdapter();

        $province = $data->get($id);
        $province = $adapter->getDataContract($province);
        
        $this->Success($province);
    }
}
