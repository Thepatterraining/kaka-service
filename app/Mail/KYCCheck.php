<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Data\Utils\DocNoMaker;

class KYCCheck extends Mailable
{
    use Queueable, SerializesModels;
    private $_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_code)
    {
        $this->code=$_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->from(config('mail.from'))->subject('咔咔买房邮箱验证')->markdown('email.KYCcheck')
        ->with(
            [
            'code'=>$this->code
            ]
        );
    }
}
