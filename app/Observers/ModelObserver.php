<?php
namespace App\Observers;

use App\Data\Notify\INotifyData;
use App\Data\Notify\DefineData;
use App\Data\Notify\NotifyDefineData;
use App\Data\Notify\NotifyGroupData;
use App\Data\Notify\NotifyGroupMemberData;
use App\Data\Notify\NotifyLogData;
use App\Data\Notify\EventLogData;
use App\Data\Notify\NotifyUserLogData;
use App\Data\Notify\NotifyGroupSetData;
use App\Data\App\UserInfoData;
use App\Data\Auth\UserData;
use App\Mail\NotifyReport;
use App\Mail\SettlementReport;
use App\Data\User\UserData as UseData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Data\MessageQueue\RabbitMQ;
use App\Http\Utils\RaiseEvent;

abstract class ModelObserver
{


    use RaiseEvent;

    protected $event_queue="";

    /**
     * 监听建立操作
     *
     * @param   $data 监听数据
     * @param   $queueData 队列数据
     * @param   $messageType 消息总类型
     * @param   $messageDetailType 消息具体类型
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
     // 2017.8.21 根据前段需求修改observer返回信息 liu
     // 2017.8.22 分离mobel liu
    public function createdHandle($data,$queueData,$messageType=null)
    {

        $jobClass = get_class($data);
        //类名判空
        if (!class_exists($jobClass)) {
            return ;
        }

        $date=date_create(date("Y-m-d H:i:s"));
        //实例化
        $jobObj = new $jobClass();

        // $queueData=(object)array();
        $queueData->key="created";
        $data->queueKey = $queueData->key;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=$jobClass;
        $queueData->data=$data;
        $queueData->messagetype=$messageType;
        $queueData->source=null;
        $rabbit=new RabbitMQ(); 
        $defineData=new DefineData();
        $notifyDefineData=new NotifyDefineData();
        // $raiseEvent=new RaiseEvent();

        $eventInfo=$defineData->newitem()->where('event_model', $jobClass)->where('event_key', "created")->first();
        //事件判空
        if (empty($eventInfo)) {
            return ;
        }

        //  $queueData=json_encode($queueData,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // dump($queueData);
        if ($eventInfo->event_queue_type==$this->event_queue) {
            $this->AddQueueEvent($this->event_queue, $queueData);
        }
    }
    /**
     * 监听更新操作
     *
     * @param   $data 监听数据
     * @param   $queueData 队列数据
     * @param   $messageType 消息总类型
     * @param   $messageDetailType 消息具体类型
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updatedHandle($data,$queueData,$messageType=null)
    {

        $jobClass = get_class($data);
        //类名判空
        if (!class_exists($jobClass)) {
            return ;
        }

        $date=date_create(date("Y-m-d H:i:s"));
        //实例化
        $jobObj = new $jobClass();

        $queueData->key="updated";
        $data->queueKey = $queueData->key;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=$jobClass;
        $queueData->data=$data;
        $queueData->messagetype=$messageType;
        $queueData->source=null;
        $rabbit=new RabbitMQ(); 
        $defineData=new DefineData();
        // $raiseEvent=new RaiseEvent();

        //找寻监听条目
        $eventInfo=$defineData->newitem()->where('event_model', $jobClass)->where('event_key', "updated")->first();
        //数据判空
        if (empty($eventInfo)) {
            return ;
        }

        // 依照表对类型进行分类
        // $queueData=json_encode($queueData,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // dump($queueData);
        if ($eventInfo->event_queue_type==$this->event_queue) {
            $this->AddQueueEvent($this->event_queue, $queueData);
        }
    }

    /**
     * 监听删除操作
     *
     * @param   $data 监听数据
     * @param   $ququeData 队列数据
     * @param   $messageType 消息总类型
     * @param   $messageDetailType 消息具体类型
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function deletedHandle($data,$queueData,$messageType=null)
    {

        $jobClass = get_class($data);
        //类名判空
        if (!class_exists($jobClass)) {
            return ;
        }

        $date=date_create(date("Y-m-d H:i:s"));
        //实例化
        $jobObj = new $jobClass();

        $queueData->key="deleted";
        $data->queueKey = $queueData->key;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=$jobClass;
        $queueData->messagetype=$messageType;
        $queueData->data=$data;
        $queueData->source=null;
        $rabbit=new RabbitMQ(); 
        $defineData=new DefineData();
        //  $raiseEvent=new RaiseEvent();

        //找寻监听条目
        $eventInfo=$defineData->newitem()->where('event_model', $jobClass)->where('event_key', "deleted")->withTrashed()->first();
        //数据判空
        if (empty($eventInfo)) {
            return ;
        }

        // 依照表对类型进行分类
        // $queueData=json_encode($queueData,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // dump($queueData);

        if ($eventInfo->event_queue_type==$this->event_queue) {
            $this->AddQueueEvent($this->event_queue, $queueData);
        }
    }

    /**
     * 监听改变操作
     *
     * @param   $data 监听数据
     * @param   $queueData 队列数据
     * @param   $messageType 消息总类型
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function savedHandle($data,$queueData,$messageType=null)
    {
        
        $jobClass = get_class($data);
        //类名判空
        if (!class_exists($jobClass)) {
            return ;
        }

        $date=date_create(date("Y-m-d H:i:s"));
        //实例化
        $jobObj = new $jobClass();

        $queueData->key="saved";
        $data->queueKey = $queueData->key;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=$jobClass;
        $queueData->messagetype=$messageType;
        $queueData->data=$data;
        $queueData->source=null;
        $rabbit=new RabbitMQ(); 
        $defineData=new DefineData();
        // $raiseEvent=new RaiseEvent();

        //找寻监听条目
        $eventInfo=$defineData->newitem()->where('event_model', $jobClass)->where('event_key', "saved")->first();
        //数据判空
        if (empty($eventInfo)) {
            return ;
        }

        // 依照表对类型进行分类
        // $queueData=json_encode($queueData,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // dump($queueData);
        if ($eventInfo->event_queue_type==$this->event_queue) {   
            $this->AddQueueEvent($this->event_queue, $queueData);
        }
    }
}

