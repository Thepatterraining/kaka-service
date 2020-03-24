<?php
namespace App\Data\MessageQueue;

interface IQueue
{

 
    
    function addToQueue($exchangeId,$data);
    function getFromQueue($queueid);
    function regPublisher($exchangeid);
    function subScribe($exchangeid,$queueid);
    function broadcastToQueue($queueId,$data);
    
}
 
