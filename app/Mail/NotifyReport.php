<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyReport extends Mailable
{
    use Queueable, SerializesModels;


 
    
    private $mailto ;
    private $name ;
    private $notifyName ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailto, $name,$notifyName,$attach)
    {

        $this->mailto = $mailto;
        $this->name = $name ;
        $this->notifyName = $notifyName;
        $this->attach = $attach;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     //2017.8.16 fix 从配置中获取发件邮箱 liu
    public function build()
    {  
        if($this->attach==null) {
            $this->from(config('mail.from'))->subject('系统自动通知')->markdown('email.notifyreport')
                ->with(
                    [
                    'name'=>$this->name,
                    'notifyname'=>$this->notifyName
                    ]
                );
        }
        else
        {
            $this->from(config('mail.from'))->subject('系统自动通知')->markdown('email.notifyreport')
                ->with(
                    [
                    'name'=>$this->name,
                    'notifyname'=>$this->notifyName
                    ]
                )->attach($this->attach);
        }
         
        return true;
    }
}
