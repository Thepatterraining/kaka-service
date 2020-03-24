<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\VoucherInfoData;

/**
 * 给用户发放现金券
 *
 * @author zhoutao
 * @date   2017.10.26
 */
class createVoucherStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:createVoucherStorage';

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
    public function handle()
    {
        $userids = [
            '5641' => 'VCN2017102616261190276',
            '5688' => 'VCN2017102617042590277',
        ];

        //发现金券
        $voucherData = new VoucherStorageData();
        $voucherInfoData = new VoucherInfoData();

        foreach ($userids as $userid => $voucherNo) {
            $this->info('用户id:' . $userid);
            $this->info('优惠券号:' . $voucherNo);

            
            $voucherInfo = $voucherInfoData->getByNo($voucherNo);
            if ($voucherInfo == null) {
                return $this->error('优惠券不存在！');
            }
            $timespan = $voucherInfo->voucher_timespan;
            $outtime = date('U') + $timespan;

            $voucherData->addStorage('', $voucherNo, '', $userid, $outtime);
        }
        $this->info('ok');
    }
}
