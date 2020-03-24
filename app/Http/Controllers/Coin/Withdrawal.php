<?php

namespace App\Http\Controllers\Coin;

use App\Data\Coin\CoinRechageData;
use App\Data\Coin\CoinWithdrawalData;
use App\Data\User\CoinAccountData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Withdrawal extends Controller
{

    protected $validateArray=[
        "amount"=>"required|numeric",
        "coin_type"=>"required",
        "userid"=>"required|exists:sys_user,id",
        "address"=>"required"
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值数量!",
        "address.required"=>"请输入提现钱包地址!",
        "coin_type.required"=>"请输入代币类型!",
        "userid.required"=>"请输入充值用户id!",
        "userid.exists:sys_user,id"=>"用户不存在!",
    ];

    /**
     * 提现代币
     *
     * @param   coin_type 代币类型
     * @param   userid 用户id
     * @param   amount 数量
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coin_type'];
        $userid = $request['userid'];
        $amount = $request['amount'];
        $address = $request['address'];

        //判断是否为一级市场
        $userCoin = new CoinAccountData();
        $userCoinRes = $userCoin->isPrimary($coinType);
        if ($userCoinRes === false) {
            //            return $this->Error(806003);
        }

        //生成单据号
        $doc = new DocNoMaker();
        $no = $doc->Generate('OW');
        $sysCoinJournalNo = $doc->Generate('OCJ');
        $userCoinJournalNo = $doc->Generate('UOJ');
        $coinJournalNo = $doc->Generate('SOJ');
        $feeNo = $doc->Generate('WF');

        $data = new CoinWithdrawalData();
        $date = date('Y-m-d H:i:s');
        $res = $data->withdrawal($coinType, $userid, $amount, $no, $coinJournalNo, $sysCoinJournalNo, $userCoinJournalNo, $feeNo, $address, $date);
        if ($res === false) {
            return $this->Error(806001);
        }

        return $this->Success($no);
    }
}
