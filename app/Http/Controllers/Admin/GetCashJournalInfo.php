<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\JournalData;
use App\Http\Adapter\Cash\JournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCashJournalInfo extends Controller
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
     * @param no 现金流水单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new JournalData();
        $adapter = new JournalAdapter();
        $item = $data->getByNo($this->request->input('no'));
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
