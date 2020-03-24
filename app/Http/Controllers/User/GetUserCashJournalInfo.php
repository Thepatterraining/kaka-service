<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashJournalData;
use App\Http\Adapter\User\CashJournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetUserCashJournalInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:user_cash_journal,usercash_journal_no",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号",
        "no.exists:user_cash_journal,usercash_journal_no"=>"单据号不存在",
    ];

    //查找现金流水信息
    /**
     * @param no 流水单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashJournalData();
        $adapter = new CashJournalAdapter();
        $filersWhere['filters']['no'] = $this->request->input('no');
        $filersWhere['filters']['userid'] = $this->session->userid;
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
