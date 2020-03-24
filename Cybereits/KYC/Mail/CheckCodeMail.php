<?php

namespace  Cybereits\Modules\KYC\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $mail;
    private $code ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$checkcode)
    {
        //
        $this->mail = $mail;
        $this->code = $checkcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     
        return  $this->from(config('mail.from'))->subject('CYBEREITS 邮件验证')->markdown('email.EmailCheck')
        ->with(
            [
            'mail'=>$this->mail,
            'code'=>$this->code,
            ]
        );
        
    }
}
