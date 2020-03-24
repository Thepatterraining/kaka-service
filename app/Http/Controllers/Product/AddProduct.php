<?php

namespace App\Http\Controllers\Product;

use App\Data\Product\InfoData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Product\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\CoinAccountData;

class AddProduct extends Controller
{

    protected $validateArray=[
        "data"=>"array|required",
        "data.price"=>"required",
        "data.count"=>"required",
        "data.cointype"=>"required|exists:item_info,coin_type",
        "data.name"=>"required",
        "data.starttime"=>"required",
         "data.type"=>"required|dic:product_type",
         "data.completiontime"=>"required_if:data.type,PRT02",
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
     * 卖出产品
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
        $price = $this->request->input('data.price');
        $coinType = $this->request->input('data.cointype');
        $starttime = $this->request->input('data.starttime');
        $name = $this->request->input('data.name');
        $count = $this->request->input('data.count');
        $type = $this->request->input('data.type');
        $completionTime = '1970-01-01';
        if ($type == InfoData::SECKILL_TYPE) {
            $completionTime = $this->request->input('data.completiontime');
        }
        $amount = $price * $count;

        //判断如果不是一级就返回错误
        $userCoinAccountData = new CoinAccountData();

        $primaryRes = $userCoinAccountData->isPrimary($coinType, $count);

        if ($primaryRes === true) {
            return $this->Error(ErrorData::$SELL_PRODUCT_NOT_JURISDICTION);
        }

        $data = new InfoData();
        $adapter = new InfoAdapter();
        
        $res = $data->add($price, $count, $coinType, $starttime, $name, $type, $completionTime);

        if ($res === false) {
            return $this->Error(ErrorData::$USER_CASH_NOT_ENOUGH);
        }

        if (count($res)) {
            $res = $adapter->getDataContract($res);
        }

        return $this->Success($res);
    }
}
