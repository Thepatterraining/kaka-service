<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;
use Cybereits\Common\Utils\ExcelMaker;
use Illuminate\Support\Facades\Mail;
use Cybereits\Modules\ICO\Mail\ICOReport;
use Cybereits\Modules\ETH\API\EtherScanApi;
use Cybereits\Modules\ICO\Data\WaletData;
use Cybereits\Modules\ICO\Data\AddressData;
use Cybereits\Modules\ICO\Data\TransLogData;

class UpdateAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:eth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update the eth amount of system';

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
        $addfac  = new WaletData();
        $api = new EtherScanApi();
        $addInfo = new AddressData();
        $all = $addInfo ->  GetList();
        $i = 0;
        $l = count($all);
        $trans= new TransLogData();
        foreach ($all as $item) {
            $i ++;
            $addr = $item -> address;
            try {
                $data = $api -> QueryEth($addr, $item->block);
           
                $cre= $api -> QueryToken($addr, $item->block);
                $transLog = $api -> QueryAddTrans($addr, $item->block);

                foreach ($transLog as $log) {
                    $trans->AddTransLog($log["from"], $log["to"], $log["eth"], $log["block"], $log["txn"], $log["gasUsed"], "ETH", 0,$log["gasPrice"]);
                }

                $tokenlogs = $api->QueryTokenTxn($addr, $item->block);
                foreach ($tokenlogs as $log) {
			dump("the token transfer ".$log["txn"]);
                    $trans->AddTransLog($log["from"], $log["to"], $log["tokentransfer"], $log["block"], $log["txn"], $log["gasUsed"], "CRE", 0,$log["gasPrice"]);
                }
                      
                $addfac ->UpdateAmount($addr, $data, $coin="ETH");
                $addfac ->UpdateAmount($addr, $cre, $coin="CRE");
                dump("{$i} of {$l} update {$addr} eth:{$data} cre:{$cre}");
            } catch (Exception $e) {
                dump($e);
            }
        }
    }
}
