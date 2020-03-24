<?php

namespace App\Http\Controllers\User;

use App\Data\Cash\BankAccountData;
use App\Data\Cash\RechargeData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Http\Adapter\Sys\CashBankAccountAdapter;
use App\Http\HttpLogic\BankLogic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\BankAccountData as UserBankAccountData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Data\Cash\FinanceBankData;
use App\Http\Adapter\Cash\FinanceBankAdapter;

class GetRechargeInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:cash_recharge,cash_recharge_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入充值单据号!",
        "no.exists"=>"充值单据号不存在!",
        "no.string"=>"充值单据号必须是字符串!",
    ];

    //查找充值详细信息
    /**
     * @param no 充值单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new RechargeData();
        $adapter = new RechargeAdapter();
        $bankfac = new BankLogic();
        $filersWhere['filters']['userid'] = $this->session->userid;
        $filersWhere['filters']['no'] = $this->request->input('no');
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);
        $res = $adapter->getDataContract($item);
        $datafac = new BankAccountData();
        $cashBankAdapter = new CashBankAccountAdapter();
        $sysBank = $datafac->getUserBankInfo(array_get($res, 'desbankid'));
        $itemtoadd = $cashBankAdapter->getDataContract($sysBank);
        $itemtoadd['bankName'] = $bankfac->getBankName($itemtoadd["bank"]);
        $branchBankName = $bankfac->getBranchBankName($itemtoadd["bank"]);
        $itemtoadd['bankName'] .= $branchBankName;
        $res['bank'] = $itemtoadd;

        //查询用户银行信息

        $userBankData = new UserBankAccountData();
        $userBankAdapter = new UserBankCardAdapter();
        $userBankInfo = $userBankData->getByNo($res['bankid']);
        $userBankInfo = $userBankAdapter->getDataContract($userBankInfo);

        //去银行表查询银行
        $bankNo = array_get($userBankInfo, 'bank', 1);
        $userBankInfo['bankName'] = $bankfac->getBankName($bankNo);
        $res['userBank'] = $userBankInfo;

        $this->Success($res);
    }
}
