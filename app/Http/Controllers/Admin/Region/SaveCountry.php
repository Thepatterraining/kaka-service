<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\CountryData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\CountryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class SaveCountry extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "data.name"=>"required",
        "data.code"=>"required",
        "data.telcode"=>"required",
        "data.fullName"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入国家id",
        "data.name.required"=>"请输入国家名称",
        "data.code.required"=>"请输入国家编号",
        "data.telcode.required"=>"请输入国家电话号",
        "data.fullName.required"=>"请输入国家全名",
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

        $country = $adapter->getData($this->request);
        $model = $data->get($id);
        $adapter->saveToModel(false, $country, $model);
        $data->save($model);
        
        $this->Success();
    }
}
