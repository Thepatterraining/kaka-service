<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\CountryData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\CountryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;
use App\Data\Region\ProvinceData;

class DeleteCountry extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入国家id",
    ];

    /**
     * 删除国家
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
        $provinceData = new ProvinceData;
        $adapter = new CountryAdapter();

        $provinceData->dels($id);
        $data->delete($id);
        
        $this->Success();
    }
}
