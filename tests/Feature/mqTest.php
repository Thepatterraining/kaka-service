<?php


namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Data\MessageQueue\RabbitMQ;


use App\Http\Utils\RaiseEvent;

class mqTest extends TestCase
{
    use RaiseEvent;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

  

        $exchangeName = "kk.test.service";
        $queueid = "kk.test.q1";
        $mq = new RabbitMQ();
        $result = $mq ->  regPublisher($exchangeName);
        dump("reg result ".$result);
      
        $mq->subScribe($exchangeName, $queueid);
          $mq ->broadcastToQueue(
              $exchangeName, array(
              "id"=>1,
              "msg"=>"hello world"
              )
          );
             /* 
        dump(config("rabbitmq.host"));
        $connection = new AMQPStreamConnection(
            config("rabbitmq.host"),
            config("rabbitmq.port"),
            config("rabbitmq.user"),
            config("rabbitmq.pwd"),
            config("rabbitmq.hostname")
        );
        
        $channel = $connection->channel();
        
        $channel->exchange_declare('test-exchanges', 'fanout', true, true, false);
        
        $msg = new AMQPMessage(json_encode('this is test!'), array('de
        livery_mode' => 2));
        $channel->basic_publish($msg, 'test-exchanges', '');
        
        $channel->close();
        $connection->close();*/

        //$this->AddEvent('Recharge_Check',229,'CR2017041216291858748');
        //$this->RaisEvent();
        $this->assertTrue(true);
    }
}   

