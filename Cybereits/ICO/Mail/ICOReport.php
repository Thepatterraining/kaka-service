<?php

namespace  Cybereits\Modules\ICO\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ICOReport extends Mailable
{
    use Queueable, SerializesModels;

    private $mail;
    private $code ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$name,$reportfile)
    {
        //
        $this->mail = $mail;
        $this->name = $name;
        $this->report = $reportfile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     
        $mail =  $this->from(config('mail.from'))
        ->subject('CYBEREITS ICO系统日报('. Date("y年m月d日").')')
        ->markdown('email.Report')
        ->with(
            [
            'name'=>$this->name
            ]
            );

        foreach ($this->report as $file){
          $mail->attach($file);
        }

        return $mail;
        
    }
}
