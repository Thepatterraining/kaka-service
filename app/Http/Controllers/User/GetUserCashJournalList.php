<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\DictionaryData;
use App\Data\User\CashJournalData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\User\CashJournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetUserCashJournalList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

    //查找账户现金流水
    /**
     * @param filters 所有的参数放在这里面
     * @param pageIndex 页码
     * @param pageSize 每页数量
     * @param startdate 开始时间
     * @param enddate 结束时间
     * @param time
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashJournalData();
        $adapter = new CashJournalAdapter();
        $resquest = $this->request->all();
        $item = $data->getJournalList($resquest['pageSize'], $resquest['pageIndex']);
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            $res[] = $arr;
        }
        $item['items'] = $res;
        return $this->Success($item);
    }
}
