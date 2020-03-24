<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Realty\RealtyData;
use App\Data\Realty\HouseData;

class CreateHouse extends Controller
{

    protected $validateArray=[
        // "data"=>"array|required",
        // "data.price"=>"required",
        // "data.count"=>"required",
        // "data.cointype"=>"required|exists:item_info,coin_type",
        // "data.name"=>"required",
        // "data.starttime"=>"required",
        //  "data.type"=>"required|dic:product_type",
        //  "data.completiontime"=>"required_if:data.type,PRT02",
    ];

    protected $validateMsg = [
        "data.price.required"=>"请输入单价!",
        "data.count.required"=>"请输入数量!",
        "data.cointype.required"=>"请输入代币类型!",
        "data.cointype.exists"=>"代币类型不存在!",
        "data.name.required"=>"请输入产品名称!",
        "data.starttime.required"=>"请输入起售时间!",
        "data.type.required"=>"请输入产品类型!",
        "data.completiontime.required_if"=>"请输入秒杀结束时间!",
    ];


    /**
     * 创建房源
     *
     * @param   $data.price
     * @param   $data.count
     * @param   $data.cointype
     * @param   $data.name
     * @param   $data.starttime
     * @param   $data.type
     * @param   $data.completiontime
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     */
    public function run()
    {
        $request = $this->request->all();
        $title = $this->request->input('title');
        $orderInfo = $this->request->input('orderInfo');
        $dealTotalPrice = $this->request->input('dealTotalPrice');
        $price = $this->request->input('price');
        $dataSpan = $this->request->input('dataSpan');
        $baseInfo = $this->request->input('baseInfo');
        $dataOrder = $this->request->input('dataOrder');
        $url = $this->request->input('url');
        $district = $this->request->input('district');

        $houseData = new HouseData;
        $house = $houseData->getByNo($dataOrder['houseHomelinkNo']);
        if (!empty($house)) {
            return $this->Success();
        }
        
        $realtyData = new RealtyData;
        $realtyData->add($url, $title, $orderInfo, $dealTotalPrice, $price, $dataSpan, $baseInfo, $dataOrder, $district);

        return $this->Success(true);
    }
}
