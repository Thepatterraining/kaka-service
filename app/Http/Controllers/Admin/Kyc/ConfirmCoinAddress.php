<?php

namespace App\Http\Controllers\Admin\Kyc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Coin\CoinAddressInfoData;
use App\Http\Adapter\Coin\CoinAddressInfoAdapter;

/**
 * 审核认证地址列表
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date 2017.12.7
 */
class ConfirmCoinAddress extends Controller
{
    protected $validateArray=[
        "confirm"=>"required",
        "address"=>"required",
    ];

    protected $validateMsg = [
        "address.required"=>"请输入钱包地址",
        "confirm.required"=>"请输入审核结果",
    ];

    public function run()
    {
        $request = $this->request->all();
        $confirm = $request['confirm'];
        $address = $request['address'];
        $data = new CoinAddressInfoData;

        if ($confirm == true) {
            $data->confirmTrue($address);
        } else {
            $data->confirmFalse($address);
        }
        
        
        $this->Success();
    }
}
