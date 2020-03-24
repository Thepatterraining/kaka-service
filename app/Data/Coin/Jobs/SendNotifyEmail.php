<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail as Mail;
use Log as Log;

class SendNotifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $toEmailAddr;
    protected $toEmailOwner;
    protected $subject;
    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->toEmailAddr = array_get($data, 'toEmailAddr');
        $this->toEmailOwner = array_get($data, 'toEmailOwner');
        $this->subject = array_get($data, 'subject');
        $this->content = array_get($data, 'content');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $errMsg = '';

        if (empty($this->toEmailAddr)) {
            $errMsg = 'send notify email failed. error: to email address is null. toEmailAddr:' . $this->toEmailAddr;
        }

        if (empty($this->content)) {
            $errMsg = 'send notify email failed. error: email content is null. content:' . $this->content;
        }

        if (!empty($errMsg)) {
            Log::error($errMsg);
            $this->delete();
        }

        // 消费队列会进入此函数
        Mail::send(
            'email.notify', ['content' => $this->content], function ($message) {
                $message->to($this->toEmailAddr, $this->toEmailOwner)->subject($this->subject);
            }
        );
    }

    /**
     * The job failed to process.
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // 任务执行失败会进入此函数
    }
}
