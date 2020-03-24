<?php

namespace App\Http\Controllers\Coin;

use App\Data\Coin\CoinRechageData;
use App\Data\Coin\CoinWithdrawalData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawalConfirm extends Controller
{

    protected $validateArray=[
        "no"=>"required|doc:coinwithdrawal,OW00",
        "confirm"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值数量!",
        "coin_type.required"=>"请输入代币类型!",
    ];

    /**
     * 提现代币
     *
     * @param   no 单据号
     * @param   confirm 是否成功
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $no = $request['no'];
        $confirm = $request['confirm'];

        //生成单据号
        $doc = new DocNoMaker();
        $sysCoinJournalNo = $doc->Generate('OCJ');
        $userCoinJournalNo = $doc->Generate('UOJ');
        $coinJournalNo = $doc->Generate('SOJ');
        $date = date('Y-m-d H:i:s');
        $data = new CoinWithdrawalData();
        if ($confirm === true) {
            $res = $data->TrueWithdrawal($no, $sysCoinJournalNo, $userCoinJournalNo, $coinJournalNo, $date);
        } else {
            $res = $data->FalseWithdrawal($no, $sysCoinJournalNo, $userCoinJournalNo, $coinJournalNo, $date);
        }

        if ($res === false) {
            return $this->Error();
        }

        return $this->Success('操作成功！');
    }
}
