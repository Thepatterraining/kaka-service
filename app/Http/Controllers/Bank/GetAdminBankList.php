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

class GetAdminBankList extends Controller
{
    protected $validateArray=[
        "pageSize"=>"required",
        "pageIndex"=>"required",
    ];

    protected $validateMsg = [
        "pageSize.required"=>"请输入每页数量!",
        "pageIndex.required"=>"请输入页码!",
    ];

    /**
     * 管理员查询银行列表
     *
     * @param   $pageSize
     * @param   $pageIndex
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function run()
    {
        $request = $this->request->all();
        $pageSize = $request['pageSize'];
        $pageIndex = $request['pageIndex'];

        $data = new FinanceBankData();
        $adapter = new FinanceBankAdapter();
        $bankadapter = new BankAdapter();
        $bankdata = new BankData();

        $filter = $adapter->getFilers($request);
        $items = $data->query($filter, $pageSize, $pageIndex);
        
        $res = [];
        if (count($items['items']) > 0) {
            foreach ($items['items'] as $val) {
                $item = $adapter->getDataContract($val);
                $res[] = $item;
            }
        }

        $items['items'] = $res;
        
        $this->Success($res);
    }
}
