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

class AddBank extends Controller
{
    /**
     * 添加银行
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
        
        $bankInfo = $adapter->getData($this->request);
        $bankModel = $data->newitem();
        $adapter->saveToModel(false, $bankInfo, $bankModel);
        $data->create($bankModel);

        $res = $adapter->getDataContract($bankModel);
        $this->Success($res);
    }
}
