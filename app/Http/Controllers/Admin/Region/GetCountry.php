<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\CountryData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\CountryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetCountry extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入国家id",
    ];

    /**
     * 添加国家
     *
     * @param   $name 国家名称
     * @param   $code 国家编号
     * @param   $telcode 国家电话号
     * @param   $fullName 国家全名
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new CountryData();
        $adapter = new CountryAdapter();

        $country = $data->get($id);
        
        $country = $adapter->getDataContract($country);
        
        $this->Success($country);
    }
}
