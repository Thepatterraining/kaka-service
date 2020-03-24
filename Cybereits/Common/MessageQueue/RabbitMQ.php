<?php
namespace Cybereits\Common\MessageQueue; 

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Cybereits\Common\MessageQueue\IMessageQueue;
class RabbitMQ implements IMessageQueue
{

 
    function getFromQueue($ququeId)
    {
        $connection = new AMQPStreamConnection(
            config("rabbitmq.host"),
            config("rabbitmq.port"),
            config("rabbitmq.user"),
            config("rabbitmq.pwd"),
            config("rabbitmq.hostname")
        );
        
 
    }
    function addToQueue($exchangeId,$data)
    {
        $connection = new AMQPStreamConnection(
              config("rabbitmq.host"),
              config("rabbitmq.port"),
              config("rabbitmq.user"),
              config("rabbitmq.pwd"),
              config("rabbitmq.hostname")
          );
        $channel = $connection->channel();
        $channel->exchange_declare($exchangeId, 'topic', true, true, true);
        $msg = new AMQPMessage(
            json_encode(
                $data,
                JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
            ), array('delivery_mode' => 2)
        );
      
        $channel->basic_publish($msg, $exchangeId);
        $channel->close();
        $connection->close();       
    
    }

    private function execReq($apiurl,$method,$body=null)
    {
        $url = "http://".config("rabbitmq.host").":".config("rabbitmq.apiport").$apiurl;//"/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeid;//; kk.php.service";
        $req = \Httpful\Request::$method($url)
            ->authenticateWith(config("rabbitmq.user"), config("rabbitmq.pwd")); //    ->body($sendStr);
        if($body != null) {
                    $sendStr = json_encode($body);
                 $req = $req->body($sendStr);
        }
        $req->addHeader(
            "Accept",
            "application/json"
        );
        $res = $req ->send();
        return $res;
    }
    /*** 
     * to check the queue is exists 
     *
     * @param queueid the name of queue 
     **/
    private function is_queue_exists($queueid)
    {
        $url  = "/api/queues/".config("rabbitmq.hostname")."/".$queueid;
        $req = $this->execReq($url, "get");
                      return $req->code != 404;
    }

    private function create_queue($queueid)
    {
         $msg = (object)array();
         $msg -> durable = true;
         $msg -> auto_delete = false ;
         $url = "/api/queues/".config("rabbitmq.hostname")."/".$queueid;
         $res = $this->execReq($url, "put", $msg);
         return $res->code === 201 || $res->code === 204;
    }
    private function is_exchange_exists($exchangeid)
    {
         $url = "/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeid;//; kk.php.service";
         $res = $this->execReq($url, "get");
      
         return $res->code != 404;
    }
    private function bind_queue_to_exchange($queueid,$exchangeid)
    {
        $url = "/api/bindings/".config("rabbitmq.hostname")."/e/".$exchangeid."/q/".$queueid;
        $res = $this->execReq($url, "get");
        if($res->code == 404  || count(
            $res->body
        )===0
        ) {
            $msg = (object)array();
            $res = $this->execReq($url, "POST", $msg);
            return true;
        }
        return true;
    }
    function regPublisher($exchangeid)
    {
        $url = "/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeid;//; kk.php.service";
        $message = array (
            "type"=>"topic",
            "auto_delete"=>false,
            "durable"=>true,
            "internal"=>false,
            "arguments"=> ((object)array())
        );
        $res = $this->execReq($url, 'put', $message);//$req ->send();
        return $res->code === 201 || $res->code === 204;
    }
    function subScribe($exchangeid,$queueid)
    {
        $exchageIsExists = $this->is_exchange_exists($exchangeid);
        if($exchageIsExists == false) {
            return false;
        }
        $queueExists = $this->is_queue_exists($queueid);
        if($queueExists == false) {
            $this->create_queue($queueid);
        }
        $this->bind_queue_to_exchange($queueid, $exchangeid);// 1. 声明 
    }
    function broadcastToQueue($exchargeId,$data)
    {
          $connection = new AMQPStreamConnection(
              config("rabbitmq.host"),
              config("rabbitmq.port"),
              config("rabbitmq.user"),
              config("rabbitmq.pwd"),
              config("rabbitmq.hostname")
          );
         $channel = $connection->channel();
         $channel->exchange_declare($exchargeId, 'topic', true, true, false);
         $msg = new AMQPMessage(
             json_encode(
                 $data,
                 JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
             ), array('delivery_mode' => 2)
         );
         $channel->basic_publish($msg, $exchargeId);
         $channel->close();
         $connection->close();
    }
    /**
     * 获取路由列表
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function getExchangeList()
    {
        $url = "/api/exchanges/".config("rabbitmq.hostname");//; kk.php.service";
        $res = $this->execReq($url, 'get');//$req ->send();
        return $res->body;
    }

    /**
     * 获取路由相关队列列表
     * exchangeId 路由名称
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function getQueueList($exchangeId)
    {
        $url = "/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeId."/bindings/source";
        $res = $this->execReq($url, 'get');//$req ->send();
        return $res->body;
    }

    /**
     * 删除路由
     * exchangeId 路由名称
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function deleteExchange($exchangeId)
    {
        $url = "/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeId."?if-unused=true";
        $res = $this->execReq($url, 'post', null);//$req ->send();
        return $res->code === 201 || $res->code === 204;
    }

    /**
     * 获取所有队列列表
     * exchangeId 路由名称
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function getAllQueueList()
    {
        $url = "/api/queues/".config("rabbitmq.hostname");
        $res = $this->execReq($url, 'get');//$req ->send();
        return $res->body;
    }

    /**
     * 删除队列
     * queue 队列名称
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function deleteQueue($queue)
    {
        $url = "/api/queues/".config("rabbitmq.hostname")."/".$queue."/contents";
        $res = $this->execReq($url, 'delete');//$req ->send();
        return $res->code === 201 || $res->code === 204;
    }

    /**
     * 获取队列信息
     * queue 路由名称
     *
     * @author liu
     * @date   2017.9.11
     */ 
    function getQueue($queue)
    {
        $url = "/api/queues/".config("rabbitmq.hostname")."/".$queue;
        $res = $this->execReq($url, 'get');//$req ->send();
        return $res->body;
    }
    private function create_delay_queue($delayqueueid,$delaytime,$queueid)
    {
         $msg = (object)array();
         $msg -> durable = true;
         $msg -> auto_delete = false ;
         $msg->arguments['x-dead-letter-exchange'] = $queueid;
         $msg->arguments['x-dead-letter-routing-key'] = $queueid;
         $msg->arguments['x-message-ttl'] = $delaytime;
         $url = "/api/queues/".config("rabbitmq.hostname")."/".$delayueueid;
         $res = $this->execReq($url, "put", $msg);
         return $res->code === 201 || $res->code === 204;
    }

    function delaySubScribe($exchangeid,$delayqueueid,$delaytime,$queueid)
    {
        $exchageIsExists = $this->is_exchange_exists($exchangeid);
        if($exchageIsExists == false) {
            return false;
        }
        $queueExists = $this->is_queue_exists($queueid);
        if($queueExists == false) {
            $this->create_queue($queueid);
        }
        $delayQueueExists = $this->is_queue_exists($delayqueueid);
        if($delayQueueExists == false) {
            $this->create_delay_queue($delayqueueid, $delaytime, $queueid);
        }
        $this->bind_queue_to_exchange($delayqueueid, $exchangeid);// 1. 声明 
    }
} 