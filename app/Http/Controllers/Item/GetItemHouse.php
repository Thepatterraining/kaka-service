<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\FormulaData;
use App\Data\Item\InfoData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetItemHouse extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型!",
    ];

    /**
     * 项目详情 查询项目信息
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function run()
    {
        $coinType = $this->request->input('coinType');
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $formulaData = new FormulaData();
        $item = $data->getItem($coinType);
        if ($item == null) {
            return $this->Error(809001);
        }
        $layoutImg = $formulaData->getLayoutImg($coinType, 'IFT02');
        $image = $formulaData->getItemImg($coinType, 'IFT03');
        $item = $adapter->getDataContract($item);
        $res['region'] = $item['diqu'] . $item['trade'];
        $res['compound'] = $item['compound'];
        $res['layout'] = $item['layout'];
        $res['number'] = $item['number'];
        $res['age'] = $item['age'];
        $res['space'] = $item['space'];
        $res['rowards'] = $item['rowards'];
        $res['renovation'] = $item['renovation'];
        $res['school'] = $item['school'];
        $res['metro'] = $item['metro'];
        $res['layoutImg'] = $layoutImg; //户型图uri
        $res['image'] = $image; //项目图片
        $this->Success($res);
    }
}
