<?php
namespace Cybereits\Common\Event;
use Illuminate\Support\Facades\Log;
use Cybereits\Common\MessageQueue\RabbitMQ;

trait RaiseEvent
{
    

    private static $queueID = "kk_service_exchange";
    private  $sessionName = \Cybereits\Common\Session::class;



    
    public function AddQueueEvent($event_queue,$queueData)
    {

       
        $session = resolve($this->sessionName);
      
        if ($session->event ==null) {
            $session->event = array();
        }
        $session->event[] = array(
        "event_queue"=>$event_queue,
        "queueData"=>$queueData,
        "pushed"=>false,
        );
    }

    public function RaiseQueueEvent()
    {

        $session = resolve($this->sessionName);
        if ($session->event == null) {
            return ;
        }
      
        $rabbit=new RabbitMQ();
        if (config("rabbitmq.enable")===true) {
            foreach($session->event as $queueInfo)
            {
               
                if($queueInfo["pushed"]===true) {
                    continue;
                }
                $queueInfo["pushed"]=true;

                $event_queue=$queueInfo['event_queue'];
                $queueData=$queueInfo['queueData'];
                if($event_queue!=null) { 
                  
                    $rabbit->addToQueue(config('rabbitmq.exname').".".$event_queue, $queueData);
                }
                else
                {
                    $rabbit->addToQueue(config('rabbitmq.exname'), $queueData);
                }
            }
        }
    }


   


}
