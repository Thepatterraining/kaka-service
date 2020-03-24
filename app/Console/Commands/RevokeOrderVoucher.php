<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\CashJournalData;
use App\Data\User\CashAccountData;

class RevokeOrderVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:revokeOrderVoucher';

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
     * 修复使用优惠券导致金额减少的bug
     *
     * @author zhoutao
     * @date   2017.9.14
     *
     * @return mixed
     */
    public function handle()
    {
        $userCashJournalData = new CashJournalData;
        $userCashAccountData = new CashAccountData;
        $model = $userCashJournalData->newitem();
        $date = date('Y-m-d H:i:s');

        $where['usercash_journal_type'] = CashJournalData::TRANSACTION_ORDER_COUPONS_TYPE;
        $where['usercash_journal_status'] = CashJournalData::ORDER_STATUS;
        $journals = $model->where($where)
            ->where('usercash_journal_out', '>', '0')
            ->where('usercash_journal_jobno', 'like', 'TO%')
            ->get();
        $sum = 0;
        if (!$journals->isEmpty()) {
            foreach ($journals as $journal) {
                $in = $journal->usercash_journal_out;
                $type = $journal->usercash_journal_type;
                $status = $journal->usercash_journal_status;
                $jobNo = $journal->usercash_journal_jobno;
                $userid = $journal->usercash_journal_userid;
                $this->info('用户id'.$userid);
                $this->info('关联单据号'.$jobNo);
                $this->info('优惠券金额'.$in);
                $userCashAccountData->increaseCash($jobNo, $in, $type, $status, $userid, $date);

                $type = CashJournalData::TYPE_VOUCHER;
                $userCashAccountData->increaseCash($jobNo, $in, $type, $status, $userid, $date);
                $this->info($sum);
                $sum += 1;
            }
        }
        return $this->info('ok');
    }
}
