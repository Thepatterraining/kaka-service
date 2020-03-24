<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\SysCash\Pay2User as  payUser;
use App\Data\User\UserData;
use App\Data\Sys\PayUserData;

class Pay2User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:pay2user {usermobile} {money}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay 2 User From Company Accounts.';

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
    public function handle()
    {



        $userFac = new UserData();
        // $sysAcount =   $this->argument('account');
        $userMobile = $this->argument("usermobile");
        $money = $this->argument("money");
        
        $user = $userFac ->getUser($userMobile);

        if($user == null ) {
            $this->error('no user found! of the mobile '.$userMobile);
        }

        $bank = "152501671";
        $pay = new PayUserData();

        $no = $pay->createPay($bank, $user->id, $money, "平台返现");
         $pay->payTrue($no);


        //
    }
}
