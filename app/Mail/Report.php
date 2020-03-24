<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;


 
    
    private $mailto ;
    private $name ;
    private $date ;
    private $attach ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     //2017.8.16 fix 从配置中获取发件邮箱 liu
    public function __construct($mailto, $name, $date, $attach)
    {

        $this->mailto = $mailto;
        $this->name = $name ;
        $this->date = $date;
        $this->subject = $date."对帐单";
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
        return $this->from(config('mail.from'))->markdown('email.report')
            ->with(
                [
                'name'=>$this->name,
                'date'=>$this->date
                ]
            ) ->attach($this->attach);
    }
}
