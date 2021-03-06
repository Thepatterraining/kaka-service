<?php

namespace App\Http\Controllers\Queue;

use App\Data\Queue\QueueHandleData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\MessageQueue\RabbitMQ;

class DeleteQueue extends Controller
{
    protected $validateArray=[
        "queue"=>"required",
    ];

    protected $validateMsg = [
        "queue.required"=>"请输入队列名称",
    ];


    /**
     * 队列信息回调操作
     *
     * @param   queue string 队列名称
     * @author  liu
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $rabbitmq=new RabbitMQ;
        $queueId=$request['queue'];
        $rabbitmq->deleteQueue($queueId);
        return $this->success("success");
    }
}
