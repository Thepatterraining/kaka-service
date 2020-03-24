<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\BankAccountData;
use App\Data\User\CoinAccountData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClearUserAccount extends Controller
{
    protected $validateArray=[
        "price"=>"required",
        "coin_type"=>"required",
    ];

    protected $validateMsg = [
        "price.required"=>"请输入单价!",
        "coin_type.required"=>"请输入代币类型!",
    ];

    /**
     * 清算
     *
     * @param   coin_type 代币类型
     * @param   price 单价
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $price = $request['price'];
        $coinType = $request['coinType'];

        //执行
        $userCoinAccountData = new CoinAccountData;
        $userCoinAccountData->clearCoin($coinType, $price);
 
        $this->Success();
    }
}
