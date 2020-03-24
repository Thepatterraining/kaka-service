<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DBErrorReport extends Mailable
{
    use Queueable, SerializesModels;
    private $dumpinfo;

    public function __construct($dumpinfo)
    {
        $this->dumpinfo=$dumpinfo;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->from(config('mail.from'))->subject('数据库错误警告')->markdown('email.dberrorreport')
            ->with(
                [
                'dumpinfo'=>$this->dumpinfo
                ]
            );
    }
}
