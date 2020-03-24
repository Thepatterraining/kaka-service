<?php

namespace App\Http\Controllers\Admin;

use App\Data\Item\InfoData;
use App\Http\Adapter\Activity\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveItemGuidePrice extends Controller
{
    protected $validateArray=[
        "guidePrice"=>"required",
        "coinType"=>"required|exists:item_info,coin_type",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
        "coinType.exists"=>"代币类型不存在，请重新输入",
        "guidePrice.required"=>"请输入指导价",
    ];

    /**
     * 修改项目指导价
     *
     * @param   coinType 代币类型
     * @param   guidePrice 指导价
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];
        $guidePrice = $request['guidePrice'];
        $data  = new InfoData();
        $res = $data->saveGuidePrice($coinType, $guidePrice);

        $this->Success($res);
    }
}
