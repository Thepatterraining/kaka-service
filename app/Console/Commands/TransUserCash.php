<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Data\Sys\PayUserData;
use App\Data\User\UserData;

class TransUserCash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:transUserCash {mobile} {amount}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Session $session)
    {
        
        $mobile = $this->argument('mobile');
        $amount = $this->argument('amount');
        $note = '临时对指定用户发放现金与优惠券需求20170913';

        if ($amount <=0 ) {
            return $this->error('返现金额需要大于0');
        }

        $userData = new UserData;
        $user = $userData->getUser($mobile);

        if (empty($user)) {
            return $this->error('用户不存在');
        }

        $userid = $user->id;
        

        $payuserData = new PayUserData;
        $session->id =$userid; 
        $sysBankNo = '152501671';
        $payNo = $payuserData->createPay($sysBankNo, $userid, $amount, $note);

        $payInfo = $payuserData->payTrue($payNo); 
        $this->info('单号：'.$payInfo->pay_no);
        $this->info('金额：'.$payInfo->pay_amount);
        $this->info('返现完成');
    }
}
