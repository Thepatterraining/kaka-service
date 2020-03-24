<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;
use App\Data\User\BankAccountData;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Cash\FinanceBankAdapter;
use App\Data\Payment\PayBanklimitData;
use App\Data\User\UserTypeData;

class GetUserBanks extends Controller
{
    /**
     * 用户查询银行列表
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function run()
    {
        $request = $this->request->all();

        $data = new FinanceBankData();
        $adapter = new FinanceBankAdapter();
        $bankadapter = new BankAdapter();
        $bankdata = new BankData();
        $bankLimitData = new PayBanklimitData;
        $userTypeData = new UserTypeData;

        $sysConfigs = $userTypeData->getData($this->session->userid);
        $channelid = $sysConfigs[UserTypeData::CASH_ULPAY_CHANNEL];
        $banks = $data->getCehckBanks();
        $res = [];
        if (count($banks) > 0) {
            foreach ($banks as $val) {
                $item = $adapter->getDataContract($val);
                $pertop = $bankLimitData->getPertop($item['no'], $channelid);
                $daytop = $bankLimitData->getDaytop($item['no'], $channelid);
                //限额改成单位 万
                $item['pertop'] = intval($pertop) / 10000;
                $item['daytop'] = intval($daytop) / 10000;
                $res[] = $item;
            }
        }

        $items['items'] = $res;
        
        $this->Success($res);
    }
}
