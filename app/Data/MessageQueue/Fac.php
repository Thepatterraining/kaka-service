<?php
namespace App\Data\MessageQueue;

use App\Data\MessageQueue\RabbitMQ;

class Fac
{
    public function createMessageQueue()
    {
        return new RabbitMQ();
    }
}
