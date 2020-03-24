<?php 
namespace App\Observers;

use App\Data\MessageQueue\RabbitMQ;

class QueueTestObserver
{

    const CHANNEL_ID="kk_event";
    const JS_ID="kk_js_event";

    public function created($data)
    {
        $event=get_class($data);
        // var_dump($event);
        if(!class_exists($event)) {
            return ;
        }

        $queueData=(object)array();
        $queueData->id=$data->id;
        $queueData->key="created";
        $queueData->event=$event;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->source=null;
        $rabbit=new RabbitMQ();
        //
         $rabbit->regPublisher("kk.php.service.event");
        $rabbit->subScribe("kk.php.service.event", self::CHANNEL_ID);
        $rabbit->subScribe("kk.php.service.event", self::JS_ID);
        $rabbit->addToQueue("kk.php.service.event", $queueData);
        return true;
    }
}