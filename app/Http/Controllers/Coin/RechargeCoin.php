<?php

namespace App\Http\Controllers\Coin;

use App\Data\Coin\CoinRechageData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeCoin extends Controller
{

    protected $validateArray=[
        "amount"=>"required|numeric",
        "coin_type"=>"required",
        "userid"=>"required|exists:sys_user,id",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值数量!",
        "coin_type.required"=>"请输入代币类型!",
        "userid.required"=>"请输入充值用户id!",
        "userid.exists:sys_user,id"=>"用户不存在!",
    ];

    /**
     * 充值代币
     *
     * @param   coin_type 代币类型
     * @param   userid 用户id
     * @param   amount 充值数量
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coin_type'];
        $userid = $request['userid'];
        $amount = $request['amount'];
        $isPrimary = false;// $request['is_primary'];

        //生成单据号
        $doc = new DocNoMaker();
        $no = $doc->Generate('OR');
        $sysCoinJournalNo = $doc->Generate('OCJ');
        $userCoinJournalNo = $doc->Generate('UOJ');

        $data = new CoinRechageData();
        $type = 'ORT01';
        $date = date('Y-m-d H:i:s');
        $res = $data->recharge($coinType, $userid, $amount, $no, $type, $sysCoinJournalNo, $userCoinJournalNo, $isPrimary, $date);
        if ($res === false) {
            return $this->Error(801012);
        }

        return $this->Success($no);
    }
}
