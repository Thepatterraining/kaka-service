<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoinErrorReport extends Mailable
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
        //$this->subject = $date."日数据".$jobno;
        $this->res=$res;

        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->from(config('mail.from'))->subject('代币查账错误警告')->markdown('email.coinerrorreport')
            ->with(
                [
                'date'=>$this->date,
                'res'=>$this->res
                ]
            );
    }
}
