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

class GetUserBankList extends Controller
{
    /**
     * 用户查询银行卡列表
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function run()
    {
        $data = new FinanceBankData();
        $userBankData = new BankAccountData();
        $userBankAdapter = new UserBankCardAdapter();
        $items = $userBankData->getUserBankList();
        $adapter = new FinanceBankAdapter();
        $bankadapter = new BankAdapter();
        $bankdata = new BankData();
        foreach ($items as $item) {
            $item2Add = $userBankAdapter->getFromModel($item, true);
            $bankModel = $bankdata->get($item2Add["bank"]);
            if ($bankModel!= null) {
                $bankContract = $bankadapter->getFromModel($bankModel);
                $financeBank = $data->getCehckBank($bankContract['no']);
                if ($financeBank != null) {
                    $financeBank = $adapter->getDataContract($financeBank);
                    $financeBank['branchName'] = $bankContract['name'];
                }
                $item2Add ["bank"]=  empty($financeBank) ? [] : $financeBank;
                $result[]=$item2Add;
            }
        }
        $this->Success($result);
    }
}
