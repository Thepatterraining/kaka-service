<?php

namespace App\Http\Controllers\Coin;

use App\Data\Coin\CoinRechageData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeConfirm extends Controller
{

    protected $validateArray=[
        "confirm"=>"required|boolean",
        "no"=>"required|doc:coinrecharge,OR00",
    ];

    protected $validateMsg = [
        "confirm.required"=>"请输入确认值!",
        "no.required"=>"请输入充值单号!",
        "confirm.boolean"=>"确认值类型不正确!",
        "no.doc:recharge,CR00"=>"充值单号不正确!",
    ];

    /**
     * 确认充值
     *
     * @param   no 单据号
     * @param   confirm true and false
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
        $date = date('Y-m-d H:i:s');
        $data = new CoinRechageData();
        if ($confirm === true) {
            $res = $data->TrueRecharge($no, $sysCoinJournalNo, $userCoinJournalNo, $date);
        } else {
            $res = $data->FalseRecharge($no, $sysCoinJournalNo, $userCoinJournalNo, $date);
        }

        if ($res === false) {
            return $this->Error();
        }

        return $this->Success('操作成功！');
    }
}
