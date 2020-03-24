<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Activity\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class AddActivity extends Controller
{
    protected $validateArray=[
        "data.name"=>"required",
        "data.limittype"=>"required|dic:activity_limit",
        "data.start"=>"required",
        "data.end"=>"required",
        "data.limitcount"=>"required|integer",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入活动名称",
        "data.limittype.required"=>"请输入活动类型",
        "data.start.required"=>"请输入开始时间",
        "data.end.required"=>"请输入结束时间",
        "data.start.datetime"=>"开始时间必须是时间类型",
        "data.end.datetime"=>"结束时间必须是时间类型",
        "data.limitcount.required"=>"请输入数量",
        "data.limitcount.integer"=>"数量必须是数字",
    ];

    /**
     * 添加现金券
     *
     * @param   $name 活动名称
     * @param   $limittype 类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @param   $limitcount 数量
     * @param   $status 状态
     * @param   $count 实际数量
     * @param   $filter 事件
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        //$request = $this->request->data;
        //        $name = $request['name'];
        //        $type = $request['type'];
        //        $start = $request['start'];
        //        $end = $request['end'];
        //        $limitCount = $request['limit_count'];
        $count = 0;
        $itemType =  $this->request->input('data.item_type');
        $voucherNo = $this->request->input('data.voucherNo');
        
        $status = 'AS00'; //未开始
        $event = '';
        //        $filter = '';
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $doc = new DocNoMaker();
        $no = $doc->Generate('SA');
        $code = $doc->getRandomString(8);

        $activity = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $activity, $model);

        $activityNo = $data->add($model, $event, $count, $status, $no, $code);

        //给活动分组
        $activityGroupData = new GroupItemData();
        $activityGroupData->addActivityGroup($activityNo);
        
        $data = new ItemData();
        if (!empty($voucherNo) && $voucherNo != 'null') {
            if (is_array($voucherNo)) {
                foreach ($voucherNo as $value) {
                    $data->addItem($no, $itemType, $value);
                }
            } else {
                $data->addItem($no, $itemType, $voucherNo);
            }
        }
        $this->Success($activityNo);
    }
}
