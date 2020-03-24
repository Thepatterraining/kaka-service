<?php

namespace Cybereits\Http;

use App\Data\Queue\QueueHandleData;
use Illuminate\Http\Request;
use Cybereits\Http\IController;
use Cybereits\Common\Event\EventHandler;

class CallBackController extends IController
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
        $handler=new EventHandler();
        $queueData = (object)$queueData;
        $handler -> Handle($queueData);
        return $this->success();
    }
}
