<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashJournalData;
use App\Http\Adapter\Sys\CashJournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSysCashJournalInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:sys_cashz_journal,syscash_journal_no",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号",
        "no.exists:sys_cashz_journal,syscash_journal_no"=>"单据号不存在",
    ];

    //查找系统现金流水表
    /**
     * @param no 系统现金流水单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashJournalData();
        $adapter = new CashJournalAdapter();
        $no = $this->request->input('no');
        $item = $data->getByNo($no);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
