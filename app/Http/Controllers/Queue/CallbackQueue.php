<?php

namespace App\Http\Controllers\Queue;

use App\Data\Queue\QueueHandleData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallbackQueue extends Controller
{
    protected $validateArray=[
        "queuedata"=>"required",
    ];

    protected $validateMsg = [
        "queuedata.required"=>"队列数据目前为空!",
    ];


    /**
     * 队列信息回调操作
     *
     * @param   queueData json 队列数据
     * @author  liu
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $queueData = $request['queuedata'];
        $queueHandleData=new QueueHandleData();
        $queueData = (object)$queueData;
        $jobClass=$queueData->event;
        if(class_exists($jobClass)) {
            $queueHandleData->handle($queueData->data, $jobClass, $queueData->key);
        }
        return $this->success("回调处理完成");
    }
}
