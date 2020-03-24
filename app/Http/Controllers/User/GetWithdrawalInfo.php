<?php

namespace App\Http\Controllers\User;

use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetWithdrawalInfo extends Controller
{

    protected $validateArray=[
        "no"=>"required|exists:cash_withdrawal,cash_withdrawal_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号!",
        "no.exists"=>"单据号不存在!",
        "no.string"=>"单据号必须是字符串!",
    ];

    //查找提现详细信息
    /**
     * @param no 提现单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new WithdrawalData();
        $adapter = new WithdrawalAdapter();
        $filersWhere['filters']['no'] = $this->request->input('no');
        $filersWhere['filters']['userid'] = $this->session->userid;
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
