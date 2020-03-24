<?php

namespace App\Http\Controllers\Queue;

use App\Data\Queue\QueueHandleData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\MessageQueue\RabbitMQ;

class DeleteExchange extends Controller
{
    protected $validateArray=[
        "exchange"=>"required",
    ];

    protected $validateMsg = [
        "exchange.required"=>"请输入路由名称",
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
        $exchangeId=$request['exchange'];
        $rabbitmq->deleteExchange($exchangeId);
        return $this->success("success");
    }
}
