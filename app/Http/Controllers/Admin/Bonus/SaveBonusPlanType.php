<?php

namespace App\Http\Controllers\Admin\Bonus;

use App\Data\Bonus\ProjBonusPlanTypeData;
use App\Http\Adapter\Bonus\ProjBonusPlanTypeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveBonusPlanType extends Controller
{

    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入计划类型id!",
    ];

    /**
     * 修改分红类型
     *
     * @author zhoutao
     * @date   2017.11.8
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new ProjBonusPlanTypeData();
        $adapter = new ProjBonusPlanTypeAdapter();

        //数据转换，赋值
        $bonusTypeInfo = $adapter->getData($this->request);
        $model = $data->get($id);
        $adapter->saveToModel(false, $bonusTypeInfo, $model);
        $data->save($model);

        $this->Success();
    }
}
