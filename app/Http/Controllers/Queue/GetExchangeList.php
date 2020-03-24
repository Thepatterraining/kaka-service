<?php

namespace App\Http\Controllers\Queue;

use App\Data\Queue\QueueHandleData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\MessageQueue\RabbitMQ;

class GetExchangeList extends Controller
{
    protected $validateArray=[

    ];

    protected $validateMsg = [

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
        $rabbitmq=new RabbitMQ;
        $res=$rabbitmq->getExhangeList();
        return $this->success($res);
    }
}
