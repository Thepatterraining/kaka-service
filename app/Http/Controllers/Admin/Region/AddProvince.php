<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\ProvinceData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\ProvinceAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class AddProvince extends Controller
{
    protected $validateArray=[
        "data.name"=>"required",
        "data.country"=>"required",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入省名",
        "data.country.required"=>"请输入国家编号",
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
        $data = new ProvinceData();
        $adapter = new ProvinceAdapter();

        $province = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $province, $model);
        $data->save($model);
        
        $this->Success();
    }
}
