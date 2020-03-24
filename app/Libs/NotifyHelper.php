<?php

namespace App\Libs;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendNotifyEmail;

class NotifyHelper
{

    use DispatchesJobs;

    public function notifyEmail($email)
    {

        $queueName = Config('queue.notify.email');

        $job = (new SendNotifyEmail($email))->onQueue($queueName)->delay(2);

        $this->dispatch($job);
    }
}
