<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CashOrderData;

class UserLedger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:userCash {user} {in} {out} {pending} {cash} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add User Journal ,Param user,in,out,pending';

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
        $userid = $this->argument('user');
        $in = $this->argument('in');
        $out = $this->argument('out');
        $pending = $this->argument('pending');
        $cash  = $this->argument('cash');

        
        //修改用户现金账户
        $userCashData = new CashAccountData();
        if ($out > 0) {
            $usercashRes = $userCashData->saveUserPendingAccountTwo($pending, $out, null, $userid);
        } elseif ($in > 0) {
            $usercashRes = $userCashData->saveUserPendingAccountTwo($pending, -$in, null, $userid);
        } else {
            $usercashRes = $userCashData->saveUserPendingAccountTwo($pending, 0, null, $userid);
        }
        $date = null;
        //修改用户现金流水
        $userCashJournalData = new CashJournalData();
        $jobNo = $userCashJournalData->addCash(null, '', $usercashRes, $pending, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER, $in, $out, $userid, $date);
        //插入用户现金纪录
        $userCashOrderData = new CashOrderData();
        $balance = $usercashRes['accountCash'];
        // $userCashOrderData->add($jobNo, $cash, CashOrderData::VOUCHER_TYPE, $balance, $userid);

        $this->info('成功');
    }
}
