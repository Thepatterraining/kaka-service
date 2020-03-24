<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyReport extends Mailable
{
    use Queueable, SerializesModels;


 
    
    private $mailto ;
    private $date ;
    private $res;
    private $attach ;
    // private $docno;
    /** 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailto, $date,$res,$attach)
    {

        $this->mailto = $mailto;
        $this->date=$date;
        $this->res=$res;
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
            return $this->from(config('mail.from'))->subject($date.'问卷调查汇总报告')->markdown('email.surveyreport')
                ->with(
                    [
                    'date'=>$this->date,
                    'res'=>$this->res
                    // 'docno'=>$this->docno
                    ]
                );//->attach($this->attach);
        }
        else
        {
            return $this->from(config('mail.from'))->subject($this->date.'问卷调查汇总报告')->markdown('email.surveyreport')
                ->with(
                    [
                    'date'=>$this->date,
                    'res'=>$this->res
                    // 'docno'=>$this->docno
                    ]
                )->attach($this->attach);
        }
    }
}
