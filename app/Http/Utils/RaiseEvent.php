<?php
namespace App\Http\Utils;

use App\Data\Sys\NotifyData;

use App\Data\Sys\MessageData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Support\Facades\Log;
use App\Data\MessageQueue\Fac as  QueueFac;
use App\Http\Adapter\AdapterFac;
use App\Data\MessageQueue\RabbitMQ;

trait RaiseEvent
{
    

    private static $queueID = "kk_service_exchange";


    
    public function AddEvent($evt, $userid, $docno)
    {
        $session = resolve('App\Http\Utils\Session');
        if ($session->evts ==null) {
            $session->evts = array();
        }
        if (array_key_exists($evt, $session->evts)==false) {
            $session->evts[$evt] = array();
        }
        $session->evts[$evt][] = array(
        "userid"=>$userid,
        "docno"=>$docno,
        "pushed"=>false,
        );
    }
    
    public function AddQueueEvent($event_queue,$queueData)
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

    public function RaisQueueEvent()
    {

     
        $session=resolve('App\Http\Utils\Session');
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

    public function RaisEvent()
    {
        $doc = new DocNoMaker();
        $session = resolve('App\Http\Utils\Session');
        if ($session->evts == null) {
            return ;
        }
        $EvtData = new NotifyData;
        $MsgData = new MessageData;
        $qFac = new QueueFac();
        $mq  = $qFac ->createMessageQueue();
        $fmtFac  = new AdapterFac();
        foreach ($session->evts as $Evt => $notiinfo) {
            $evtdf = $EvtData->getByNo($Evt);
            if ($evtdf!= null) {
                foreach ($notiinfo as $nodify) {
                    if($nodify["pushed"]===true) {
                        continue;
                    }
                    $nodify["pushed"]=true;
                    $no = $doc->Generate('MSG');
                    $msg = $MsgData->newitem();
                    $userid = $nodify["userid"];
                    $msg->msg_to = $userid;
                    $msg->msg_no = $no;
                    $msg->msg_docno = $nodify["docno"];
                    $msg->msg_model = $evtdf->notify_model;
                    $msg->msg_status = "MSG01";
                    $item = $this->_getData($evtdf->notify_model, $nodify["docno"]);
                    $msg->msg_text =$this->getMsg($evtdf->notify_fmt, $item);
                    $msg->msg_type= $evtdf->notify_type;
                    $msg->notify_id = $evtdf->id;
                    $fmt = $fmtFac->getDataContract($item);
                    $evtArray = array(
                        "model" =>$evtdf->notify_model,
                        "evt"   =>$evtdf->noiffy_event,
                        "data"  =>$fmt,
                        "userid"=>$userid,
                    );
                   // dump($evtArray);
                    if (config("rabbitmq.enable")===true) {
                                   $mq->addToQueue("kk_service_exchange", $evtArray);
                    }
                    $MsgData->create($msg);
                }
            }
        }
    }


    protected function getMsg($fmt, $item)
    {
        
        if ($item === null) {
            return $fmt."item null";
        }
        $phpstr = "return \"".$fmt."\";";
         
        $msg = eval($phpstr);
        return $msg;
    }

    private function strlen($msg)
    {
        return strlen($msg);
    }
    private function substr($msg, $i, $l)
    {
        return substr($msg, $i, $l);
    }
    private function right($msg, $i)
    {
        return substr($msg, strlen($msg)-$i);
    }
    private function _getData($modelname, $id)
    {
        $calssname = "App\Data\\".$modelname."Data";
      
            $datafac = new $calssname();
            $item = $datafac->getByNo($id);
            return $item ;
  
        return null;
    }


}
