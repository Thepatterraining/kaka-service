<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CashErrorReport extends Mailable
{
    use Queueable, SerializesModels;

    private $date ;
    private $res;
    // private $attach ;
    // private $docno;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($date,$res)
    {
        $this->date=$date;
        $this->res=$res;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->from(config('mail.from'))->subject('现金查账错误警告')->markdown('email.casherrorreport')
            ->with(
                [
                'date'=>$this->date,
                'res'=>$this->res
                ]
            );
    }
}
