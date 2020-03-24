<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobReport extends Mailable
{
    use Queueable, SerializesModels;


 
    
    private $mailto ;
    private $name ;
    private $date ;
    private $attach ;
    private $docno;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailto, $name,$jobno, $attach)
    {

        $this->mailto = $mailto;
        $this->name = $name ;
        $this->docno = $jobno;
        $this->subject = "报表定制".$jobno;
        $this->attach = $attach;

        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->from(config('mail.from'))->markdown('email.jobreport')
            ->with(
                [
                'name'=>$this->name,
                'docno'=>$this->docno
                ]
            ) ->attach($this->attach);
    }
}
