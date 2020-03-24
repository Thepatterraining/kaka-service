<?php
namespace App\Http\Utils;

trait Queue
{

    public function CallbackQueueHandle($data,$queue,$messageKey)
    {
        $queueData=(object)array();

        $date=date_create(date("Y-m-d H:i:s"));

        // $queueData=(object)array();
        $queueData->key=$data->queueKey;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=null;
        $queueData->data=$data;
        $queueData->source=null;
        $queueData->messageKey=$messageKey;

        $this->AddQueue($queue, $queueData);
    }

    private function AddQueue($event_queue,$queueData)
    {
        $session = resolve('App\Http\Utils\Session');
        if ($session->event ==null) {
            $session->event = array();
        }
        $session->event[] = array(
        "event_queue"=>$event_queue,
        "queueData"=>$queueData,
        "pushed"=>false,
        );
    }
}