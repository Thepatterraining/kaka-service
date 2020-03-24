<?php
namespace Cybereits\Common\MessageQueue; 

interface IMessageQueue
{

 
    
    function addToQueue($exchangeId,$data);
    function getFromQueue($queueid);
    function regPublisher($exchangeid);
    function subScribe($exchangeid,$queueid);
    function broadcastToQueue($queueId,$data);
    
}